<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referred_by')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('pin');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('image');
            $table->string('password');
            $table->string('assign');
            $table->decimal('earnings', 8, 2)->default(0.00);
            $table->decimal('wallet_balance', 8, 2)->default(0.00);
            $table->string('role');
            $table->boolean('is_Active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('referred_by')->references('id')->on('clients')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
