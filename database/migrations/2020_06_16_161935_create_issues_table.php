<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('author_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->enum('status', ['open', 'closed']);
            $table->boolean('is_locked')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();

            //$table->foreignId('author_id')->references('social_id')->on('users');
            //$table->foreignId('project_id')->references('id')->on('projects');
            //$table->foreignId('thread_id')->references('id')->on('issue_threads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
