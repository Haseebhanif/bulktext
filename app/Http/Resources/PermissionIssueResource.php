<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionIssueResource extends JsonResource
{

    public function toArray($request)
    {
        return [
          'status'=>401,
          'message'=>'Unauthorized call speak to your provider'
        ];
    }
}
