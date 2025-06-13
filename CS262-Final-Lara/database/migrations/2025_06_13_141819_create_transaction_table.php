<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->decimal('amount', 10, 2);
            $table->foreignId('user_id')->nullable()->constrained('user', 'user_id');
            $table->foreignId('org_id')->nullable()->constrained('organization', 'org_id');
            $table->foreignId('admin_id')->constrained('admin', 'admin_id');
            $table->timestamp('transaction_date')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction');
    }
};
