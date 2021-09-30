<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\NewsletterDeliveryStatus;

class CreateNewsletterRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_recipients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('newsletter_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipient_id')->constrained('customers')->cascadeOnDelete();
            $table->unsignedSmallInteger('delivery_status')->default(NewsletterDeliveryStatus::PENDING);

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
        Schema::dropIfExists('newsletter_recipients');
    }
}
