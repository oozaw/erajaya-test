<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChartResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request) {
        // return data for chart
        $companies = $this->groupBy('company_id');
        $series = [];
        $categories = $this->unique('period')->pluck('period')->toArray();

        foreach ($companies as $company) {
            $companyName = $company[0]->company->company_name;
            $data = [];

            foreach ($categories as $category) {
                $data[] = $company->where('period', $category)->count();
            }

            $series[] = [
                'name' => $companyName,
                'data' => $data
            ];
        }

        return [
            'series' => $series,
            'categories' => $categories,
        ];
    }
}
