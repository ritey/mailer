<?php

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
            $table->integer('site_id')->index()->default(0);
            $table->string('class')->index();
            $table->string('name',128)->index();
            $table->text('value');
            $table->boolean('serialized')->default(0);
        });

        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('enabled')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('email',196)->index();
        });

        Schema::create('emails_sites', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('email_id')->index();
            $table->integer('site_id')->index();
        });

        Schema::create('emails_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('email_id')->index();
            $table->integer('tag_id')->index();
        });

        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('enabled')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('name',196)->index();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('enabled')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('name',196)->index();
        });

        Schema::create('log', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->string('name',196)->index();
            $table->text('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
        Schema::drop('emails');
        Schema::drop('emails_sites');
        Schema::drop('emails_tags');
        Schema::drop('sites');
        Schema::drop('tags');
        Schema::drop('log');
    }
}