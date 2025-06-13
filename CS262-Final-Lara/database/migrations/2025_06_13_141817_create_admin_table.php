<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id('admin_id');
            $table->string('username', 50);
            $table->string('email', 100);
            $table->string('password', 255);
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at');
            $table->binary('profile_image')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
    }
};
