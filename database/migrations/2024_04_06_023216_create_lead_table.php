<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead', function (Blueprint $table) {
            $table->id();
            $table->date('Date')->nullable();
            $table->string('Branch')->nullable();
            $table->string('ResourceID')->nullable();
            $table->string('CompanyName')->nullable();
            $table->string('ContactPerson')->nullable();
            $table->string('MobileNumber', 15)->nullable();
            $table->string('MailId')->nullable();
            $table->text('Address')->nullable();
            $table->string('PinCode', 10)->nullable();
            $table->string('Product')->nullable();
            $table->string('Service')->nullable();
            $table->date('NextFollowUpDate')->nullable();
            $table->text('Remarks')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead');
    }
}
