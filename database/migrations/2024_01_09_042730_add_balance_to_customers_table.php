<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('customers') && !Schema::hasColumn('customers', 'balance')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->decimal('balance', 15, 2)->default(0.00);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('customers') && Schema::hasColumn('customers', 'balance')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('balance');
            });
        }
    }
};
