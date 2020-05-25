<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Wallet extends Resource
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
            'points' => $this->points ?? 0,
            'created_at' => $this->created_at ?? now(),
        ];
    }
}
