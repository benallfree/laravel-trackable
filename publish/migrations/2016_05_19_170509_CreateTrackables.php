<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->nullable();
            $table->timestamps();
            $table->index('site_id');
        });

        Schema::create('contact_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id');
            $table->string('key');
            $table->longtext('value');
            $table->boolean('is_current')->default(true);
            $table->timestamps();
            $table->index('contact_id');
            $table->index('key');
            $table->index(['contact_id', 'key']);
            $table->index(['contact_id', 'key', 'is_current']);
            $table->index('is_current');
        });
        
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id');
            $table->string('event');
            $table->string('ip_address')->nullable();
            $table->string('request_method')->nullable();
            $table->string('url')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->longtext('data')->nullable();
            $table->float('duration')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            $table->index('contact_id');
            $table->index('event');
            $table->index('ip_address');
            $table->index('url');
            $table->index('duration');
            $table->index('ended_at');
        });
        


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sites');
        Schema::drop('contacts');
        Schema::drop('contact_metas');
        Schema::drop('actions');
    }
}
