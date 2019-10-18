<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSubscriptionsTable.
 */
class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->json('keywords')->nullable();
            $table->integer('frequency')->default(60);
            $table->bigInteger('telegram_user_id');
            $table->string('service');
            $table->foreign('telegram_user_id')
                ->references('id')
                ->on('telegram_users')
                ->onDelete('cascade');

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
        Schema::table('inline_commands', function (Blueprint $table) {
            $table->dropForeign('subscriptions_telegram_user_id_foreign');
        });
        Schema::drop('subscriptions');
    }
}
