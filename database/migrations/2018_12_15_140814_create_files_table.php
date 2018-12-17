<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('owner_id')->unsigned()->index()->nullable();
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');

            $table->integer('pos')->default(0);
            $table->string('filename');

            $table->string('name')->nullable();
            $table->string('alt')->nullable();
            $table->string('title')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
