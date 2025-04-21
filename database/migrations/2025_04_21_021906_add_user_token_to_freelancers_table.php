<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserTokenToFreelancersTable extends Migration
{
    public function up()
    {
        Schema::table('freelancers', function (Blueprint $table) {
            $table->string('user_token')->unique()->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('freelancers', function (Blueprint $table) {
            $table->dropColumn('user_token');
        });
    }
}
