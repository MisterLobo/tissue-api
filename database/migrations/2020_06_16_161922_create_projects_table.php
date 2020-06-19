<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->enum('owner_type', ['user', 'org']);
            $table->string('title');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            //$table->foreign('owner_id')->references('social_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
