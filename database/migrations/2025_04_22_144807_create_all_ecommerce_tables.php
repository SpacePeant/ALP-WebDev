<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
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
            $table->foreignId('category_id')->nullable()->constrained('category');
            $table->timestamps();
        });

        Schema::create('product_color', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('product')->onDelete('cascade');
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
            $table->foreignId('color_id')->constrained('product_color')->onDelete('cascade');
            $table->string('image_kiri', 255);
            $table->string('image_kanan', 255);
            $table->string('image_atas', 255);
            $table->string('image_bawah', 255);
            $table->timestamps();
        });

        Schema::create('product_variant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('product')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('product_color')->onDelete('cascade');
            $table->integer('size');
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();
        });

        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('product')->onDelete('cascade');
            $table->timestamp('added_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'product_id']);
            $table->timestamps();
        });

        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('product')->onDelete('cascade');
            $table->tinyInteger('rating');
            $table->text('review_title');
            $table->text('comment')->nullable();
            $table->date('review_date')->nullable();
            $table->timestamps();
        });
        
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('product')->onDelete('cascade');
            $table->foreignId('product_color_id')->constrained('product_color')->onDelete('cascade');
            $table->foreignId('product_variant_id')->constrained('product_variant')->onDelete('cascade');
            $table->boolean('is_pilih')->default(false);
            $table->integer('quantity');
            $table->timestamp('added_at')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('order_date');
            $table->string('status', 20);
            $table->string('payment_method', 50)->nullable();
            $table->text('payment_url')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->string('cust_name');
            $table->text('cust_address');
            $table->string('cust_phone_number', 15);
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('product')->onDelete('cascade');
            $table->foreignId('product_color_id')->constrained('product_color')->onDelete('cascade');
            $table->foreignId('product_variant_id')->constrained('product_variant')->onDelete('cascade');
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
            $table->foreignId('user_id')->constrained('users'); 
            $table->string('action', 100);
            $table->string('target_table', 100);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('access_token');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        DB::unprepared("
            CREATE TRIGGER before_insert_product_color
            BEFORE INSERT ON product_color
            FOR EACH ROW
            BEGIN
                DECLARE r INT;
                DECLARE g INT;
                DECLARE b INT;
                DECLARE luminosity INT;

                SET r = CONV(SUBSTRING(NEW.color_code_bg, 2, 2), 16, 10);
                SET g = CONV(SUBSTRING(NEW.color_code_bg, 4, 2), 16, 10);
                SET b = CONV(SUBSTRING(NEW.color_code_bg, 6, 2), 16, 10);

                SET luminosity = ROUND(0.2126 * r + 0.7152 * g + 0.0722 * b);

                IF luminosity < 128 THEN
                    SET NEW.color_font = '#ffffff';
                ELSE
                    SET NEW.color_font = '#333';
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER before_update_product_color
            BEFORE UPDATE ON product_color
            FOR EACH ROW
            BEGIN
                DECLARE r INT;
                DECLARE g INT;
                DECLARE b INT;
                DECLARE luminosity INT;

                SET r = CONV(SUBSTRING(NEW.color_code_bg, 2, 2), 16, 10);
                SET g = CONV(SUBSTRING(NEW.color_code_bg, 4, 2), 16, 10);
                SET b = CONV(SUBSTRING(NEW.color_code_bg, 6, 2), 16, 10);

                SET luminosity = ROUND(0.2126 * r + 0.7152 * g + 0.0722 * b);

                IF luminosity < 128 THEN
                    SET NEW.color_font = '#ffffff';
                ELSE
                    SET NEW.color_font = '#333';
                END IF;
            END;
        ");

        DB::unprepared('
            CREATE TRIGGER reduce_stock
            AFTER INSERT ON order_details
            FOR EACH ROW
            BEGIN
                UPDATE product_variant
                SET stock = stock - NEW.quantity
                WHERE id = NEW.product_variant_id;
            END
        ');
        
        DB::unprepared('
            CREATE TRIGGER trg_restore_stock_on_expired
            AFTER UPDATE ON orders
            FOR EACH ROW
            BEGIN
                DECLARE done INT DEFAULT FALSE;
                DECLARE v_product_variant_id BIGINT;
                DECLARE v_quantity INT;

                DECLARE cur CURSOR FOR
                    SELECT product_variant_id, quantity
                    FROM order_details
                    WHERE order_id = NEW.id;

                DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

                IF NEW.status = "expired" AND OLD.status != "expired" THEN
                    OPEN cur;

                    read_loop: LOOP
                        FETCH cur INTO v_product_variant_id, v_quantity;

                        IF done THEN
                            LEAVE read_loop;
                        END IF;

                        UPDATE product_variant
                        SET stock = stock + v_quantity
                        WHERE id = v_product_variant_id;
                    END LOOP;

                    CLOSE cur;
                END IF;
            END
        ');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('users');
        DB::unprepared("DROP TRIGGER IF EXISTS before_insert_product_color;");
        DB::unprepared("DROP TRIGGER IF EXISTS before_update_product_color;");
        DB::unprepared('DROP TRIGGER IF EXISTS reduce_stock');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_restore_stock_on_expired');
    }
};