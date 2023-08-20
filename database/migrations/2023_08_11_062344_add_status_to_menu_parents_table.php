<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToMenuParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_parents', function (Blueprint $table) {
            $table->string('status')->default('active'); // New field named 'status' with a default value of 'active'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_parents', function (Blueprint $table) {
            $table->dropColumn('status'); // Rollback: Drop the 'status' field
        });
    }
}
