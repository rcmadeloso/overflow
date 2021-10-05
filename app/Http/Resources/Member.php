<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Account as AccountResource;
use App\Http\Resources\Score as ScoreResource;



class Member extends JsonResource
{
    /**
        Using Resource allows you to manipulate and have control over which data you will send and expose
        This is very helpful in keeping your data safe because you are only exposing what you want and not the whole table data.
        
        See : https://laravel.com/docs/8.x/eloquent-resources
    **/
    public function toArray($request)
    {
        return [
            'full_name' => $this->full_name,
            'email' => $this->email,
            'status' => $this->status,
            'status_label' => $this->status_label,

            // Relationships
            'accounts' => AccountResource::collection($this->accounts),
            'score' => new ScoreResource($this->score),
        ];
    }
}
