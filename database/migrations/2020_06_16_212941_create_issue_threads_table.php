<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_threads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('issue_id');
            $table->unsignedBigInteger('author_id');
            $table->boolean('is_locked')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();

            //$table->foreignId('project_id')->references('id')->on('projects');
            //$table->foreignId('issue_id')->references('id')->on('issues');
            //$table->foreignId('author_id')->references('social_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_threads');
    }
}
