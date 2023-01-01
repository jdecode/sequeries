<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('github_id')->nullable()->index();
            $table->string('github_email')->nullable()->index();
            $table->string('github_token')->nullable();
            $table->boolean('github_oauth_status')->default(false);
            $table->dateTime('github_oauth_timestamp')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('github_id');
            $table->dropColumn('github_email');
            $table->dropColumn('github_token');
            $table->dropColumn('github_oauth_status');
            $table->dropColumn('github_oauth_timestamp');
        });
    }
};
