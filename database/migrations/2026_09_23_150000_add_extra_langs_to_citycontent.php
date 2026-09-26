<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraLangsToCitycontent extends Migration
{
    /**
     * City edit stores title/content for ar, en, fr, fa, ru on citycontent.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citycontent', function (Blueprint $table) {
            $table->string('title_fr', 250)->nullable();
            $table->longText('content_fr')->nullable();
            $table->string('title_fa', 250)->nullable();
            $table->longText('content_fa')->nullable();
            $table->string('title_ru', 250)->nullable();
            $table->longText('content_ru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('citycontent', function (Blueprint $table) {
            $table->dropColumn(array('title_fr', 'content_fr', 'title_fa', 'content_fa', 'title_ru', 'content_ru'));
        });
    }
}
