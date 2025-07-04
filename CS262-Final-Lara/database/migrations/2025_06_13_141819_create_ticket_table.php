<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->foreignId('event_id')->constrained('event', 'event_id');
            $table->foreignId('payment_id')->constrained('payment', 'payment_id');
            $table->string('ticket_code')->unique();
            $table->timestamp('purchase_date');
            $table->decimal('total_price', 8, 2);
            $table->foreignId('user_id')->constrained('user', 'user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket');
    }
};
