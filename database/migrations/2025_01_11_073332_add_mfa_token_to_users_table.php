<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mfa_token')->nullable(); // Add mfa_token column
            $table->timestamp('mfa_token_expires_at')->nullable(); // Add mfa_token_expires_at column
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mfa_token');
            $table->dropColumn('mfa_token_expires_at');
        });
    }
};
