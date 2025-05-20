<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->text('address')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->date('registration_date')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('filename');
            $table->text('article');
            $table->timestamps();
        });

        Schema::create('blog_image', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('title1');
            $table->string('title2');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('gender', ['Men', 'Women', 'Unisex']);
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->timestamps();
        });

        Schema::create('product_color', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('color_name', 50);
            $table->boolean('is_primary')->default(false);
            $table->string('color_code', 7)->nullable(); 
            $table->string('color_code_bg', 7)->nullable();
            $table->string('color_font', 7)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('product_color_image', function (Blueprint $table) {
            $table->id();
            $table->foreignId('color_id')->constrained('product_colors')->onDelete('cascade');
            $table->string('image_kiri', 255);
            $table->string('image_kanan', 255);
            $table->string('image_atas', 255);
            $table->string('image_bawah', 255);
        });

        Schema::create('product_variant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('product_colors')->onDelete('cascade');
            $table->integer('size');
            $table->unsignedInteger('stock')->default(0);
        });

        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->timestamp('added_at')->nullable();
            $table->timestamps();
            $table->unique(['customer_id', 'product_id']);
        });

        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->tinyInteger('rating');
            $table->text('review_title');
            $table->text('comment')->nullable();
            $table->date('review_date')->nullable();
            $table->timestamps();
        });
        
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_color_id')->constrained('product_colors')->onDelete('cascade');
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade');
            $table->boolean('is_pilih')->default(false);
            $table->integer('quantity');
            $table->timestamp('added_at')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->dateTime('order_date');
            $table->string('status', 20);
            $table->string('payment_method', 50);
            $table->text('payment_url');
            $table->decimal('total_amount', 12, 2);
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_color_id')->constrained('product_colors')->onDelete('cascade');
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();
        });

        Schema::create('shipping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            $table->text('shipping_address');
            $table->string('courier', 50);
            $table->string('tracking_number', 50)->nullable();
            $table->string('shipping_status', 20);
            
            $table->unsignedInteger('origin_city_id')->nullable();
            $table->unsignedInteger('destination_city_id')->nullable();
            $table->unsignedInteger('total_weight')->default(1000);
            
            $table->unsignedInteger('shipping_cost')->nullable();
            $table->string('etd', 50)->nullable();
        
            $table->dateTime('shipped_date')->nullable();
            $table->dateTime('delivered_date')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('payment_method', 50);
            $table->string('payment_status', 20);
            $table->dateTime('payment_date');
            $table->decimal('total_paid', 12, 2);
            $table->timestamps();
        });

        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins'); 
            $table->string('action', 100);
            $table->string('target_table', 100);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('access_token');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_tokens');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('shipping');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('product_reviews');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('product_color');
        Schema::dropIfExists('product_color_image');
        Schema::dropIfExists('product_variant');
        Schema::dropIfExists('product');
        Schema::dropIfExists('category');
        Schema::dropIfExists('blog_image');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('customers');
    }
};