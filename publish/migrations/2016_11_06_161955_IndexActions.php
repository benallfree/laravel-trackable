<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndexActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      \DB::statement(\DB::raw("CREATE INDEX actions_url_index ON actions (url(1024))"));
      \DB::statement(\DB::raw("CREATE INDEX actions_user_agent_index ON actions (user_agent(1024))"));
      \DB::statement(\DB::raw("CREATE INDEX actions_referer_index ON actions (referer(1024))"));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            //
        });
    }
}
