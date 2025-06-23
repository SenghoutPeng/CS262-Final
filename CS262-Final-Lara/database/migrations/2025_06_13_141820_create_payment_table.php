<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('user_id')->constrained('user', 'user_id');
            $table->foreignId('event_id')->constrained('event', 'event_id');
            $table->integer('quantity');
            $table->decimal('amount', 8, 2);
            $table->enum('payment_status', ['Completed', 'Rejected']);
            $table->timestamp('payment_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment');
    }
};
