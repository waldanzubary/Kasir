<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('active_date_histories', function (Blueprint $table) {
            $table->timestamp('active_date')->nullable()->after('activated_at');
        });
    }

    public function down()
    {
        Schema::table('active_date_histories', function (Blueprint $table) {
            $table->dropColumn('active_date');
        });
    }
};
