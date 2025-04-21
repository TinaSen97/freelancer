<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToFreelancersTable extends Migration
{
    public function up()
    {
        Schema::table('freelancers', function (Blueprint $table) {
            $table->string('skills', 255)->after('email');
            $table->text('experience')->after('skills');
            $table->text('bio')->after('experience');
            $table->string('facebook_url')->nullable()->after('bio');
            $table->string('twitter_url')->nullable()->after('facebook_url');
            $table->string('instagram_url')->nullable()->after('twitter_url');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('pinterest_url')->nullable()->after('linkedin_url');
            $table->string('profile_picture')->nullable()->after('pinterest_url');
            $table->string('cover_photo')->nullable()->after('profile_picture');
        });
    }

    public function down()
    {
        Schema::table('freelancers', function (Blueprint $table) {
            $table->dropColumn([
                'skills',
                'experience',
                'bio',
                'facebook_url',
                'twitter_url',
                'instagram_url',
                'linkedin_url',
                'pinterest_url',
                'profile_picture',
                'cover_photo'
            ]);
        });
    }
}
