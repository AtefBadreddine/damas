<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWhatsappNumberToCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * Country WhatsApp number used on geo pages (/turkiye, /oman, …).
     * Neutral pages keep using params.tel_1 / tel_2 for the current locale.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('countries')) {
            return;
        }

        if (!Schema::hasColumn('countries', 'whatsapp_number')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->string('whatsapp_number', 30)->nullable()->after('code');
            });
        }

        $defaults = array(
            'turkey' => '905551605000',
            'oman'   => '96898272585',
        );
        foreach ($defaults as $code => $number) {
            DB::table('countries')
                ->where('code', $code)
                ->where(function ($query) {
                    $query->whereNull('whatsapp_number')->orWhere('whatsapp_number', '');
                })
                ->update(array('whatsapp_number' => $number));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('countries') && Schema::hasColumn('countries', 'whatsapp_number')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->dropColumn('whatsapp_number');
            });
        }
    }
}
