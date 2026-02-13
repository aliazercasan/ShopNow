<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if using SQLite
        if (DB::getDriverName() === 'sqlite') {
            // SQLite doesn't support ENUM or MODIFY COLUMN
            // The status column already exists as string, so we don't need to modify it
            // SQLite will accept any string value, validation should be done at application level
            return;
        }
        
        // MySQL/MariaDB
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Check if using SQLite
        if (DB::getDriverName() === 'sqlite') {
            return;
        }
        
        // MySQL/MariaDB
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending'");
    }
};
