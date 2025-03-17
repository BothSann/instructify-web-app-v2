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
        Schema::table('manuals', function (Blueprint $table) {
            $table->unsignedBigInteger('uploaded_by_admin')->nullable()->after('uploaded_by');
            $table->foreign('uploaded_by_admin')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manuals', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by_admin']);
            $table->dropColumn('uploaded_by_admin');
        });
    }
};
