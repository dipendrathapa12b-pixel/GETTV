
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sport_matches', function (Blueprint $table) {
            $table->id();

            // Sport selection
            $table->string('sport_type')->default('football');
            $table->string('custom_sport_name')->nullable();

            // Match information
            $table->string('title');
            $table->string('competition')->nullable();

            // Home team
            $table->string('home_team');
            $table->string('home_team_logo')->nullable();

            // Away team
            $table->string('away_team');
            $table->string('away_team_logo')->nullable();

            // Schedule
            $table->date('match_date');
            $table->time('match_time');

            // Match status
            $table->string('status')->default('upcoming');

            // Visibility
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sport_matches');
    }
};
