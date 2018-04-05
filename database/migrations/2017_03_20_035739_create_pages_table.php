<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->integer('category_id')->nullable()->unsigned()->references('id')->on('categories');
            $table->string('title');
            $table->text('intro')->nullable();
            $table->mediumText('markup');
            $table->text('metakey')->nullable();
            $table->text('metadesc')->nullable();
            $table->char('publish', 1);
            $table->char('featured', 1)->nullable();
            $table->timestamps();

            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
