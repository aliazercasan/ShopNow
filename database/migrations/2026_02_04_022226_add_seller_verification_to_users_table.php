<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tin_number')->nullable()->after('role');
            $table->string('business_permit')->nullable()->after('tin_number');
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending')->after('business_permit');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tin_number', 'business_permit', 'verification_status']);
        });
    }
};
