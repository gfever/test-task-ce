<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('value')->nullable();
        });

        \App\Models\Setting::insert(['name' => \App\Models\Setting::BALANCE_SETTING_NAME, 'value' => 0]);
        \App\Models\Setting::insert(['name' => \App\Models\Setting::MAX_BONUS_PRIZE_AMOUNT_SETTING_NAME, 'value' => 100]);
        \App\Models\Setting::insert(['name' => \App\Models\Setting::MAX_CASH_PRIZE_AMOUNT_SETTING_NAME, 'value' => 100]);
        \App\Models\Setting::insert(['name' => \App\Models\Setting::CASH_TO_BONUSES_MULTIPLIER_SETTING_NAME, 'value' => 2]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
