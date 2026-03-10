<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page', 50);          // home|about|guide|contact|blog
            $table->string('key', 100);           // hero_title, hero_subtitle, etc.
            $table->string('label', 150);         // human-readable label for admin form
            $table->longText('value')->nullable();
            $table->string('type', 20)->default('text'); // text|textarea|richtext|json
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['page', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
