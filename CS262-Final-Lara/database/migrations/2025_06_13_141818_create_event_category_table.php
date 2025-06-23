<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_category', function (Blueprint $table) {
            $table->id('event_category_id');
            $table->string('event_category_name', 255);
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_category');
    }
};
