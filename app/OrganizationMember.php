<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OrganizationMember extends Authenticatable
{
    protected $guard = 'member';

    protected $table = 'organization_members';

    protected $fillable = ['fname','lname','email','password','mobile','api_token','type'];

    /**
     * Get user wallet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function wallet(){
        return $this->morphOne(Wallet::class,'user');
    }
}
