<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade'); //外部キー制約の設定
            $table->string('first_name');
            $table->string('last_name');
            $table->tinyInteger('gender')
                ->unsigned()->comment('1: 男性, 2: 女性, 3: その他');
            $table->string('email');
            $table->string('tel');
            $table->string('address');
            $table->string('building')->nullable();
            $table->text('detail');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
