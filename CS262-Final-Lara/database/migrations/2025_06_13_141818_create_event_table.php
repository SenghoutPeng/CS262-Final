<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->id('event_id');
            $table->foreignId('org_id')->nullable()->constrained('organization', 'org_id');
            $table->foreignId('admin_id')->constrained('admin', 'admin_id');
            $table->foreignId('event_category_id')->constrained('event_category', 'event_category_id');
            $table->string('title', 255);
            $table->text('description');
            $table->date('proposed_date');
            $table->string('location', 255);
            $table->decimal('ticket_price', 10, 2);
            $table->integer('total_ticket');
            $table->string('status', 255)->default('pending');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at');
            $table->binary('banner')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event');
    }
};
