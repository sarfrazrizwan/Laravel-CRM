<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('company_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('town')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('status')->nullable();
            $table->json('meta')->nullable();

            $table->enum('user_type', \App\Enums\UserType::getValues());

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
