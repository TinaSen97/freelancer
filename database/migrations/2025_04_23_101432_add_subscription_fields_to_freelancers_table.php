<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('freelancers', function (Blueprint $table) {
            // Subscription Plan Info
            $table->integer('user_subscr_id')->default(0);
            $table->string('user_subscr_type', 100)->nullable();
            $table->float('user_subscr_price')->default(0);
            $table->date('user_subscr_date')->nullable();
            $table->string('user_subscr_payment_status', 191)->nullable();
            $table->string('user_subscr_payment_type', 191)->nullable();
            $table->string('user_subscr_item_level', 50)->nullable();
            $table->integer('user_subscr_item')->default(0);
            $table->mediumInteger('user_subscr_download_item')->default(0);
            $table->mediumInteger('user_today_download_limit')->default(0);
            $table->date('user_today_download_date')->nullable();
            $table->string('user_subscr_space_level', 50)->nullable();
            $table->integer('user_subscr_space')->default(0);
            $table->string('user_subscr_space_type', 100)->nullable();

            // Payment Options
            $table->string('user_payment_option', 200)->nullable();

            // Currency & Pricing
            $table->string('currency_type', 191)->nullable();
            $table->string('currency_type_code', 191)->nullable();
            $table->string('user_single_price', 191)->default('0');

            // Stripe
            $table->string('user_stripe_type', 191)->default('charges');
            $table->string('user_stripe_mode', 50)->nullable();
            $table->string('user_test_publish_key', 200)->nullable();
            $table->string('user_test_secret_key', 200)->nullable();
            $table->string('user_live_publish_key', 200)->nullable();
            $table->string('user_live_secret_key', 200)->nullable();

            // PayPal
            $table->string('user_paypal_email', 200)->nullable();
            $table->string('user_paypal_mode', 200)->nullable();

            // Paystack
            $table->string('user_paystack_public_key', 200)->nullable();
            $table->string('user_paystack_secret_key', 200)->nullable();
            $table->string('user_paystack_merchant_email', 200)->nullable();

            // Razorpay
            $table->string('user_razorpay_key', 200)->nullable();
            $table->string('user_razorpay_secret', 200)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('freelancers', function (Blueprint $table) {
            $table->dropColumn([
                'user_subscr_id', 'user_subscr_type', 'user_subscr_price', 'user_subscr_date',
                'user_subscr_payment_status', 'user_subscr_payment_type', 'user_subscr_item_level',
                'user_subscr_item', 'user_subscr_download_item', 'user_today_download_limit',
                'user_today_download_date', 'user_subscr_space_level', 'user_subscr_space',
                'user_subscr_space_type', 'user_payment_option', 'currency_type', 'currency_type_code',
                'user_single_price', 'user_stripe_type', 'user_stripe_mode', 'user_test_publish_key',
                'user_test_secret_key', 'user_live_publish_key', 'user_live_secret_key',
                'user_paypal_email', 'user_paypal_mode', 'user_paystack_public_key',
                'user_paystack_secret_key', 'user_paystack_merchant_email', 'user_razorpay_key',
                'user_razorpay_secret'
            ]);
        });
    }
};
