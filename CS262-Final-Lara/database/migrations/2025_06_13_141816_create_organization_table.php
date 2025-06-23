<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('organization', function (Blueprint $table) {
            $table->id('org_id');
            $table->string('org_name', 255);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('contact_name', 255);
            $table->string('contact_phone', 255);
            $table->string('contact_email', 255);
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->timestamp('created_at');
            $table->string('org_type', 125);
            $table->timestamp('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('organization');
    }
};
