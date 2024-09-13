<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arr=[
            'id'=>$this->id,
            'username'=>$this->username,
            'email'=>$this->phone,
            'type'=>$this->type,
            'creared_at'=>$this->created_at->format('Y-m-d H:i:s'),
        ];
        if(isset($this->token)){
            $arr['token']=$this->token;
        }
        return $arr;
    }
}
