<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->foreignId('company_id')
                ->constrained()
                ->onDelete('cascade');


            $table->string('image')->nullable();
            $table->string('town')->nullable();
            $table->string('postal_code')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
