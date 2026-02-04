<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Seller User
        $seller = User::create([
            'name' => 'John Seller',
            'email' => 'seller@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
        ]);

        // Create Customer User
        User::create([
            'name' => 'John Doe',
            'email' => 'customer@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Electronic devices and gadgets'],
            ['name' => 'Clothing', 'slug' => 'clothing', 'description' => 'Fashion and apparel'],
            ['name' => 'Books', 'slug' => 'books', 'description' => 'Books and literature'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'description' => 'Home and garden products'],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports equipment and accessories'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Sample Products
        $products = [
            ['name' => 'Wireless Headphones', 'category_id' => 1, 'price' => 79.99, 'stock' => 50, 'description' => 'High-quality wireless headphones with noise cancellation', 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500'],
            ['name' => 'Smartphone', 'category_id' => 1, 'price' => 599.99, 'stock' => 30, 'description' => 'Latest smartphone with advanced features', 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500'],
            ['name' => 'Laptop', 'category_id' => 1, 'price' => 1299.99, 'stock' => 20, 'description' => 'Powerful laptop for work and gaming', 'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500'],
            ['name' => 'T-Shirt', 'category_id' => 2, 'price' => 19.99, 'stock' => 100, 'description' => 'Comfortable cotton t-shirt', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500'],
            ['name' => 'Jeans', 'category_id' => 2, 'price' => 49.99, 'stock' => 75, 'description' => 'Classic denim jeans', 'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500'],
            ['name' => 'Sneakers', 'category_id' => 2, 'price' => 89.99, 'stock' => 60, 'description' => 'Stylish and comfortable sneakers', 'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=500'],
            ['name' => 'Fiction Novel', 'category_id' => 3, 'price' => 14.99, 'stock' => 200, 'description' => 'Bestselling fiction novel', 'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500'],
            ['name' => 'Cookbook', 'category_id' => 3, 'price' => 24.99, 'stock' => 150, 'description' => 'Delicious recipes for home cooking', 'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500'],
            ['name' => 'Coffee Maker', 'category_id' => 4, 'price' => 79.99, 'stock' => 40, 'description' => 'Automatic coffee maker', 'image' => 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=500'],
            ['name' => 'Garden Tools Set', 'category_id' => 4, 'price' => 39.99, 'stock' => 80, 'description' => 'Complete set of garden tools', 'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=500'],
            ['name' => 'Yoga Mat', 'category_id' => 5, 'price' => 29.99, 'stock' => 120, 'description' => 'Non-slip yoga mat', 'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=500'],
            ['name' => 'Basketball', 'category_id' => 5, 'price' => 24.99, 'stock' => 90, 'description' => 'Official size basketball', 'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=500'],
        ];

        foreach ($products as $product) {
            Product::create([
                'seller_id' => $seller->id,
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'image' => $product['image'] ?? null,
                'is_active' => true,
            ]);
        }
    }
}
