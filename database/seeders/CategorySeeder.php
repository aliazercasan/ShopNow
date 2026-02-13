<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
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
            Category::updateOrCreate(
                ['slug' => $category['slug']], // Check if exists by slug
                $category // Update or create with these values
            );
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}
