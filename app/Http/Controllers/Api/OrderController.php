<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //

    public function store(Request $request)
    {
        $validated = $request->validate([
            'products'          => 'required|array',
            'products.*.id'     => 'exists:products,id',
            'products.*.quantity' => 'integer|min:1',
            'user_id'           => 'required|exists:users,id',
        ]);

        
        // Calculate total and create order
        DB::beginTransaction();
        try {
            $total = $this->calculateTotal($validated['products']);
            
            $order = Order::create([
                'user_id'       => $request->user_id,
                'grand_total'   => $total['subtotal'],
                'shipping_cost' => $total['shipping'],
                'discount'      => $total['discount']
            ]);

            // Create order details
            $this->createOrderDetails($order, $validated['products']);

            DB::commit();
            return response()->json([
                'order'     => $order->load('orderDetails'),
                'message'   => 'Order created successfully'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message'   => 'Order creation failed',
                'error'     => $e->getMessage()
            ], 500);
        }
    }

    private function calculateTotal($products)
    {
        $subtotal       = 0;
        $shippingCost   = 10; 
        $discount       = 0;

        foreach ($products as $item) {
            $product = Product::findOrFail($item['id']);
            $subtotal += $product->price * $item['quantity'];
        }

        if ($subtotal > 100) {
            $discount = $subtotal * 0.1;
        }

        return [
            'subtotal' => $subtotal,
            'shipping' => $shippingCost,
            'discount' => $discount,
            'total' => $subtotal + $shippingCost - $discount
        ];
    }

    private function createOrderDetails($order, $products)
    {
        foreach ($products as $item) {
            $product = Product::findOrFail($item['id']);
            OrderDetail::create([
                'order_id'      => $order->id,
                'product_id'    => $product->id,
                'quantity'      => $item['quantity'],
                'unit_price'    => $product->price
            ]);
        }
    }

}
