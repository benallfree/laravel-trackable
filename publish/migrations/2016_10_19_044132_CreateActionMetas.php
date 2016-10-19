<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionMetas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('action_id');
            $table->string('key');
            $table->longtext('value')->nullable();
            $table->timestamps();
            $table->index('action_id');
            $table->index('key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_metas');
    }
}
