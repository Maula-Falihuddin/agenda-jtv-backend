<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('daily', function (Blueprint $table) {
        $table->boolean('is_checked')->default(false);
    });
}

public function down()
{
    Schema::table('daily', function (Blueprint $table) {
        $table->dropColumn('is_checked');
    });
}
};
