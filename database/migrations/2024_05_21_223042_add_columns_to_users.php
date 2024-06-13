<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable(); //ニックネーム
            $table->string('phone_number')->nullable(); //電話番号
            $table->string('occupation')->nullable(); //職業
            $table->smallInteger('age')->nullable(); //年齢
            $table->date('subscription_end_date')->nullable(); //サブスク終了日
            $table->boolean('subscription_flag')->nullable()->default(null); //サブスクフラグ
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nickname'); //ニックネーム
            $table->dropColumn('phone_number'); //電話番号
            $table->dropColumn('occupation'); //職業
            $table->dropColumn('age'); //年齢
            $table->dropColumn('subscription_end_date'); //サブスク終了日
            $table->dropColumn('subscription_flag'); //サブスクフラグ
        });
    }
};
