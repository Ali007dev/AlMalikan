<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? null,
            'user_id' => $this->user_id ?? null,
            'employee_id' => $this->employee_id ?? null,
            'operation_id' => $this->operation_id ?? null,
            'branch_id' => $this->branch_id ?? null,
            'date' => $this->date ?? null,
            'time' => $this->time ?? null,
            'end_time' => $this->end_time ?? null,
            'status' => $this->status ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
            'day' => $this->day ?? null,
            'branchName' => $this->branch->name,
            'customerFirstName' =>$this->customer->first_name,
            'customerLastName' =>$this->customer->last_name,
            'serviceName' =>$this->service->name,

            'customer' => new CustomerResource($this->customer) ?? null,
            'employee' => $this->employee ? new EmployeeResource($this->employee) : null,
            // 'branch' => new BranchResource($this->branch) ?? null,
            'service' => new ServiceResource($this->service)?? null
                ];    }
}
