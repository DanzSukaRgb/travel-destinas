<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('country');
            $table->string('city');
            $table->enum('category', ['Beach', 'Mountain', 'City', 'Nature', 'Cultural', 'Adventure']);
            $table->string('image');
            $table->json('gallery')->nullable();
            $table->text('description');
            $table->string('short_description', 200);
            $table->json('highlights')->nullable();
            $table->json('activities')->nullable();
            $table->string('best_time')->nullable();
            $table->string('estimated_budget')->nullable();
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->integer('reviews_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->decimal('latitude',  10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
