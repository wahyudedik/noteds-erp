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
        if (Schema::hasTable('customers') && !Schema::hasColumn('customers', 'credit_note_balance')) {
            Schema::table('customers', function (Blueprint $table) {
                // Check if balance column exists, if yes add after it, otherwise add at the end
                if (Schema::hasColumn('customers', 'balance')) {
                    $table->string('credit_note_balance')->after('balance')->default('0.00');
                } else {
                    $table->string('credit_note_balance')->default('0.00');
                }
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
        if (Schema::hasTable('customers') && Schema::hasColumn('customers', 'credit_note_balance')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('credit_note_balance');
            });
        }
    }
};
