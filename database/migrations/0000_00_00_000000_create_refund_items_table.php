<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('refund_id')->index()->comment('所属退款单');
            $table->unsignedBigInteger('order_id')->comment('所属订单');
            $table->unsignedBigInteger('order_item_id')->comment('详情ID');
            $table->string('item_type')->comment('商品类型');
            $table->unsignedBigInteger('item_id')->comment('商品编号');
            $table->unsignedInteger('qty')->comment('数量');
            $table->unsignedDecimal('price', 20, 2)->comment('单价');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refund_items');
    }

}
