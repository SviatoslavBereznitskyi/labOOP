<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMessagesTable.
 */
class CreateInlineCommandsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('inline_commands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keyboard_command')->nullable();
            $table->string('model')->nullable();
            $table->integer('model_id')->nullable();
            $table->bigInteger('telegram_user_id');

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
            $table->dropForeign('inline_commands_telegram_user_id_foreign');
        });
		Schema::drop('inline_commands');
	}
}
