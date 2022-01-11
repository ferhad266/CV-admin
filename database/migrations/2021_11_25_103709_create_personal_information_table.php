<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('main_title');
            $table->text('about_text');
            $table->string('btn_contact_text')->nullable();
            $table->string('small_title_left')->nullable();
            $table->string('small_title_right')->nullable();
            $table->string('full_name');
            $table->string('image')->nullable();
            $table->string('task_name');
            $table->string('birthday');
            $table->string('website');
            $table->string('phone');
            $table->string('mail');
            $table->string('address');
            $table->string('cv')->nullable();
            $table->text('languages')->nullable();
            $table->text('interests')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal');
    }
}
