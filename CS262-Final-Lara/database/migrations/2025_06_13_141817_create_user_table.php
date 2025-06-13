<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username', 255);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->timestamp('created_at');
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->binary('profile_image')->nullable();
            $table->timestamp('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
};
