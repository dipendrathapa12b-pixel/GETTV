
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();

            // Section information
            $table->string('title');
            $table->string('section_type');

            // Optional custom sport filter
            $table->string('sport_type')->nullable();

            // Display settings
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedInteger('matches_limit')->default(10);

            // Visibility
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_sections');
    }
};
