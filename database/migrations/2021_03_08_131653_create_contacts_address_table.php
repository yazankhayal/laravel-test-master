<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts_address', function (Blueprint $table) {
            $table->id();

            $table->string('post_code');

            $table->integer('contacts_id')->unsigned();
            $table->foreign('contacts_id')
                ->references('id')
                ->on('contacts');

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
        Schema::dropIfExists('contacts_address');
    }
}
