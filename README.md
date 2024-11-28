# Rest Api of Category with Products

## Features
- Product CRUD operations
- Category management
- Order create
- Product reviews
- Sorting

## Requirements
- PHP 8.2+
- Composer
- MySQL
- Laravel 11.x

## Installation Steps

### 1. Clone Repository
```bash
git clone https://github.com/ashik194/rest-api-category-product.git

```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

## API Endpoints

### Sorting
- `best_sell`
- `top_rated`
- `price_high_to_low`
- `price_low_to_high`

- `GET /api/category/{slug}/products`: Sorting List products

### Products
- `GET /api/products`: List products
- `GET /api/products/{slug}`: Product details
- `POST /api/products`: Create product
- `PUT /api/products/{id}`: Update product
- `DELETE /api/products/{id}`: Delete product

### Categories
- `GET /api/categories`: List categories
- `GET /api/categories/{slug}`: Category details
- `POST /api/categories`: Create category
- `PUT /api/categories/{id}`: Update category
- `DELETE /api/categories/{id}`: Delete category

### Orders
- `POST /api/orders`: Create order

### Reviews
- `POST /api/products/{productId}/reviews`: Create review
- `GET /api/products/{productId}/reviews`: List reviews
- `PUT /api/reviews/{reviewId}`: Update reviews
- `DELETE /api/reviews/{reviewId}`: Update reviews

## Testing
```bash
php artisan serve
```
