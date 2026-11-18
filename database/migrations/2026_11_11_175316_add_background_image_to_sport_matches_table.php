
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sport_matches', function (Blueprint $table) {
            $table->string('background_image')->nullable()->after('away_team_logo');
        });
    }

    public function down(): void
    {
        Schema::table('sport_matches', function (Blueprint $table) {
            $table->dropColumn('background_image');
        });
    }
};
