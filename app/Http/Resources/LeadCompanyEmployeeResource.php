<?php

namespace App\Http\Resources;

use App\Actions\TranslateIconNames;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadCompanyEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $webInfo = (new TranslateIconNames())->index($this->company->country);

        $cvr = preg_replace("/[^0-9]/", "", $this->company->cvr);
        $website = "{$webInfo['company_url']}/$cvr";

        return [
            'cvr' => $this->company->cvr,
            'name' => $this->company->name,
            'employees' => $this->employees,
            'website' => $website,
            'phone' => $this->company->phone,
            'address' => $this->company->address,
            'country' => $this->company->country,
            'email' => $this->company->email,
        ];
    }
}
