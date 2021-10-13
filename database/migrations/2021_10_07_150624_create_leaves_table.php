<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->integer('days_applied');
            $table->integer('outstanding_days'); //outstanding days
            $table->integer('leave_type');
            $table->integer('year');
            $table->integer('duty_reliever');
            $table->integer('approval_id');
            $table->integer('user_id');
            $table->integer('status')->default(0);
            $table->integer('allowance');
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('leaves');
    }
}
