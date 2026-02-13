<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data first (optional - comment out if you want to keep existing data)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('order_items')->truncate();
        \DB::table('orders')->truncate();
        \DB::table('cart_items')->truncate();
        \DB::table('products')->truncate();
        \DB::table('categories')->truncate();
        \DB::table('users')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Multiple Sellers
        $seller1 = User::create([
            'name' => 'John Seller',
            'email' => 'seller@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
            'is_seller_verified' => true,
            'shop_name' => 'Tech Paradise',
        ]);

        $seller2 = User::create([
            'name' => 'Sarah Fashion',
            'email' => 'sarah@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
            'is_seller_verified' => true,
            'shop_name' => 'Fashion Hub',
        ]);

        $seller3 = User::create([
            'name' => 'Mike Books',
            'email' => 'mike@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
            'is_seller_verified' => true,
            'shop_name' => 'Book Haven',
        ]);

        // Create Multiple Customers
        $customer1 = User::create([
            'name' => 'John Doe',
            'email' => 'customer@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $customer2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $customer3 = User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob@shopnow.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Electronic devices and gadgets'],
            ['name' => 'Clothing & Fashion', 'slug' => 'clothing-fashion', 'description' => 'Fashion and apparel'],
            ['name' => 'Books & Media', 'slug' => 'books-media', 'description' => 'Books, magazines, and media'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'description' => 'Home and garden products'],
            ['name' => 'Sports & Outdoors', 'slug' => 'sports-outdoors', 'description' => 'Sports equipment and outdoor gear'],
            ['name' => 'Beauty & Personal Care', 'slug' => 'beauty-personal-care', 'description' => 'Cosmetics and personal care products'],
            ['name' => 'Toys & Games', 'slug' => 'toys-games', 'description' => 'Toys, games, and entertainment'],
            ['name' => 'Automotive', 'slug' => 'automotive', 'description' => 'Car parts and accessories'],
            ['name' => 'Health & Wellness', 'slug' => 'health-wellness', 'description' => 'Health and wellness products'],
            ['name' => 'Jewelry & Accessories', 'slug' => 'jewelry-accessories', 'description' => 'Jewelry, watches, and accessories'],
            ['name' => 'Pet Supplies', 'slug' => 'pet-supplies', 'description' => 'Pet food, toys, and accessories'],
            ['name' => 'Office Supplies', 'slug' => 'office-supplies', 'description' => 'Office and school supplies'],
            ['name' => 'Baby & Kids', 'slug' => 'baby-kids', 'description' => 'Baby and children products'],
            ['name' => 'Food & Beverages', 'slug' => 'food-beverages', 'description' => 'Food, drinks, and groceries'],
            ['name' => 'Furniture', 'slug' => 'furniture', 'description' => 'Home and office furniture'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Sample Products
        $products = [
            // Tech Paradise Products (Seller 1)
            ['seller' => $seller1, 'name' => 'Wireless Headphones', 'category_id' => 1, 'price' => 79.99, 'stock' => 50, 'description' => 'High-quality wireless headphones with noise cancellation', 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500'],
            ['seller' => $seller1, 'name' => 'Smartphone', 'category_id' => 1, 'price' => 599.99, 'stock' => 30, 'description' => 'Latest smartphone with advanced features', 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500'],
            ['seller' => $seller1, 'name' => 'Laptop', 'category_id' => 1, 'price' => 1299.99, 'stock' => 20, 'description' => 'Powerful laptop for work and gaming', 'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500'],
            ['seller' => $seller1, 'name' => 'Smart Watch', 'category_id' => 1, 'price' => 249.99, 'stock' => 45, 'description' => 'Fitness tracking smart watch', 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500'],
            ['seller' => $seller1, 'name' => 'Bluetooth Speaker', 'category_id' => 1, 'price' => 59.99, 'stock' => 70, 'description' => 'Portable wireless speaker', 'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500'],
            
            // Fashion Hub Products (Seller 2)
            ['seller' => $seller2, 'name' => 'T-Shirt', 'category_id' => 2, 'price' => 19.99, 'stock' => 100, 'description' => 'Comfortable cotton t-shirt', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500'],
            ['seller' => $seller2, 'name' => 'Jeans', 'category_id' => 2, 'price' => 49.99, 'stock' => 75, 'description' => 'Classic denim jeans', 'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500'],
            ['seller' => $seller2, 'name' => 'Sneakers', 'category_id' => 2, 'price' => 89.99, 'stock' => 60, 'description' => 'Stylish and comfortable sneakers', 'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=500'],
            ['seller' => $seller2, 'name' => 'Jacket', 'category_id' => 2, 'price' => 129.99, 'stock' => 40, 'description' => 'Warm winter jacket', 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500'],
            ['seller' => $seller2, 'name' => 'Dress', 'category_id' => 2, 'price' => 79.99, 'stock' => 55, 'description' => 'Elegant evening dress', 'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=500'],
            
            // Book Haven Products (Seller 3)
            ['seller' => $seller3, 'name' => 'Fiction Novel', 'category_id' => 3, 'price' => 14.99, 'stock' => 200, 'description' => 'Bestselling fiction novel', 'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500'],
            ['seller' => $seller3, 'name' => 'Cookbook', 'category_id' => 3, 'price' => 24.99, 'stock' => 150, 'description' => 'Delicious recipes for home cooking', 'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500'],
            ['seller' => $seller3, 'name' => 'Self-Help Book', 'category_id' => 3, 'price' => 18.99, 'stock' => 180, 'description' => 'Motivational self-help guide', 'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500'],
            ['seller' => $seller3, 'name' => 'Science Fiction', 'category_id' => 3, 'price' => 16.99, 'stock' => 160, 'description' => 'Epic sci-fi adventure', 'image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=500'],
            
            // Mixed Sellers - Home & Garden
            ['seller' => $seller1, 'name' => 'Coffee Maker', 'category_id' => 4, 'price' => 79.99, 'stock' => 40, 'description' => 'Automatic coffee maker', 'image' => 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=500'],
            ['seller' => $seller2, 'name' => 'Garden Tools Set', 'category_id' => 4, 'price' => 39.99, 'stock' => 80, 'description' => 'Complete set of garden tools', 'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=500'],
            ['seller' => $seller1, 'name' => 'Blender', 'category_id' => 4, 'price' => 49.99, 'stock' => 65, 'description' => 'High-speed blender', 'image' => 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=500'],
            
            // Sports Products
            ['seller' => $seller2, 'name' => 'Yoga Mat', 'category_id' => 5, 'price' => 29.99, 'stock' => 120, 'description' => 'Non-slip yoga mat', 'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=500'],
            ['seller' => $seller3, 'name' => 'Basketball', 'category_id' => 5, 'price' => 24.99, 'stock' => 90, 'description' => 'Official size basketball', 'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=500'],
            ['seller' => $seller2, 'name' => 'Dumbbells Set', 'category_id' => 5, 'price' => 89.99, 'stock' => 50, 'description' => 'Adjustable dumbbells', 'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=500'],
        ];

        $createdProducts = [];
        foreach ($products as $product) {
            $createdProducts[] = Product::create([
                'seller_id' => $product['seller']->id,
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

        // Create Sample Orders
        $orderStatuses = ['pending', 'processing', 'shipped', 'delivered'];
        
        // Order 1 - Customer 1
        $order1 = Order::create([
            'user_id' => $customer1->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => $orderStatuses[array_rand($orderStatuses)],
            'total_amount' => 679.98,
            'customer_name' => $customer1->name,
            'customer_email' => $customer1->email,
            'customer_phone' => '+1234567890',
            'shipping_address' => '123 Main St, New York, NY 10001',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $createdProducts[0]->id,
            'quantity' => 1,
            'price' => 79.99,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $createdProducts[1]->id,
            'quantity' => 1,
            'price' => 599.99,
        ]);

        // Order 2 - Customer 2
        $order2 = Order::create([
            'user_id' => $customer2->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => $orderStatuses[array_rand($orderStatuses)],
            'total_amount' => 159.97,
            'customer_name' => $customer2->name,
            'customer_email' => $customer2->email,
            'customer_phone' => '+1234567891',
            'shipping_address' => '456 Oak Ave, Los Angeles, CA 90001',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $createdProducts[5]->id,
            'quantity' => 2,
            'price' => 19.99,
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $createdProducts[7]->id,
            'quantity' => 1,
            'price' => 89.99,
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $createdProducts[10]->id,
            'quantity' => 2,
            'price' => 14.99,
        ]);

        // Order 3 - Customer 3
        $order3 = Order::create([
            'user_id' => $customer3->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => 'delivered',
            'total_amount' => 1299.99,
            'customer_name' => $customer3->name,
            'customer_email' => $customer3->email,
            'customer_phone' => '+1234567892',
            'shipping_address' => '789 Pine Rd, Chicago, IL 60601',
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $createdProducts[2]->id,
            'quantity' => 1,
            'price' => 1299.99,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Login credentials:');
        $this->command->info('   Admin: admin@shopnow.com / password');
        $this->command->info('   Sellers: seller@shopnow.com, sarah@shopnow.com, mike@shopnow.com / password');
        $this->command->info('   Customers: customer@shopnow.com, jane@shopnow.com, bob@shopnow.com / password');
    }
}
