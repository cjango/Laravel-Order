<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->index()->comment('所属订单');
            $table->string('orderid', 32)->comment('退款单号');
            $table->unsignedBigInteger('seller_id')->nullable()->comment('订单商户');
            $table->unsignedBigInteger('user_id')->comment('下单用户');
            $table->unsignedDecimal('refund_total', 20, 2)->comment('申请退款金额');
            $table->unsignedDecimal('actual_total', 20, 2)->comment('实退金额');
            $table->string('state', 16)->comment('状态')->nullable();
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamp('refunded_at')->nullable()->comment('退款时间');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refunds');
    }

}
