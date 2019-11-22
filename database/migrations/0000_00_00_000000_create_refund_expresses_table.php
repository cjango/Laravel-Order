<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundExpressesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_expresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('refund_id')->index()->comment('所属退款单');
            $table->string('company')->nullable()->comment('退款物流');
            $table->string('number')->nullable()->comment('退款单号');
            $table->timestamp('deliver_at')->nullable()->comment('寄回时间');
            $table->timestamp('receive_at')->nullable()->comment('收到时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refund_expresses');
    }

}
