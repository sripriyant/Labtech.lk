<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_parameters', function (Blueprint $table) {
            if (!Schema::hasColumn('test_parameters', 'show_interpretation')) {
                $table->boolean('show_interpretation')->default(true)->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('test_parameters', function (Blueprint $table) {
            if (Schema::hasColumn('test_parameters', 'show_interpretation')) {
                $table->dropColumn('show_interpretation');
            }
        });
    }
};
