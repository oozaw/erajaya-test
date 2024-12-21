<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request) {
        return [
            'name' => $this->employee->employee_name,
            'level' => $this->level->level_name,
            'division' => $this->company->company_name,
            'period' => $this->period,
            'gender' => $this->gender?->gender_name,
        ];
    }
}
