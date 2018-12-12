<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldcontentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fieldcontents', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('field_id');
            $table->foreign('field_id')
                ->references('id')
                ->on('fields')
                ->onDelete('cascade');

            $table->unsignedInteger('owner_id');
            $table->foreign('owner_id')
                ->references('id')
                ->on('owners')
                ->onDelete('cascade');

            $table->text('content')->nullable();
            $table->json('data')->nullable();

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
        Schema::dropIfExists('fieldcontents');
    }
}
