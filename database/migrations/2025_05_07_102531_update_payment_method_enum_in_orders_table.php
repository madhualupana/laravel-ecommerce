<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Update the enum by using raw SQL (MySQL only)
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('cod', 'stripe', 'paypal', 'razorpay') NOT NULL");
    }

    public function down(): void
    {
        // Revert back to old enum
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('cod', 'stripe', 'paypal') NOT NULL");
    }
};
