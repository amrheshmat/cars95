<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'club_id', 'amount', 'sender_request_number', 'service_id',
        'service_request_id', 'request_object', 'encrypted_request_object',
        'request_decryption_key','user_unique_identifier'
    ];
}
