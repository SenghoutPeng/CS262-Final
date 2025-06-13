<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->id('rating_id');
            $table->foreignId('user_id')->constrained('user', 'user_id');
            $table->foreignId('rating_category_id')->constrained('rating_category', 'rating_category_id');
            $table->foreignId('event_id')->constrained('event', 'event_id');
            $table->timestamp('created_at');
            $table->decimal('rating', 8, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating');
    }
};
