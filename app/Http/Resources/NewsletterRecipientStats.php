<?php

namespace App\Http\Resources;

use App\Enums\NewsletterDeliveryStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsletterRecipientStats extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'pending' => $this->getCount(NewsletterDeliveryStatus::PENDING),
            'sent' => $this->getCount(NewsletterDeliveryStatus::SENT),
            'opened' => $this->getCount(NewsletterDeliveryStatus::OPENED),
        ];
    }
    private function getCount($deliveryStatus)
    {
        return $this->recipients->where('delivery_status', $deliveryStatus)->count();
    }
}
