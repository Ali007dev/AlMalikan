<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
    'id' => $this->id,
    'first_name' => $this->first_name,
    'middle_name' => $this->middle_name,
    'last_name' => $this->last_name,
    'recent_customer_reservation' => !empty($this->recentCustomerReservation) ? new ReservationResource($this->recentCustomerReservation) : null,
];


    }
}
