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
        Schema::table('members', function (Blueprint $table) {
            $table->foreignId('family_id')->nullable()->after('id')->constrained()->onDelete('set null');
            $table->string('family_role')->nullable()->after('family_id'); // Kepala Keluarga, Istri, Anak, dll
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['family_id']);
            $table->dropColumn(['family_id', 'family_role']);
        });
    }
};
