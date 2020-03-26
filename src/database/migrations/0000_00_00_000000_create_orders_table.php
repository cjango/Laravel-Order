<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('orderid', 32)->comment('订单编号');
            $table->unsignedBigInteger('seller_id')->nullable()->comment('订单商户');
            $table->unsignedBigInteger('user_id')->comment('下单用户');
            $table->unsignedDecimal('amount', 20, 2)->comment('订单金额');
            $table->unsignedDecimal('freight', 10, 2)->nullable()->comment('运费');
            $table->string('status', 16)->default('0000')->comment('4码订单状态');
            $table->string('state', 16)->comment('状态')->nullable();
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamp('paid_at')->nullable()->comment('支付时间');
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
        Schema::dropIfExists('orders');
    }

}
