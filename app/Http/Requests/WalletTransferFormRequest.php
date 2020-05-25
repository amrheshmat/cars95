<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class WalletTransferFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $senderUser = $this->user();
        $receiverUser = $this->route('user');
        $data = $this->all();
        
        if(!$senderUser->wallet){
            throw new ValidationException($this,response()->json([
                "message" => "Invalid sender wallet"
            ]));
        }
        // if(!$receiverUser->wallet){
        //     throw new ValidationException($this,response()->json([
        //          "message" => "Invalid receiver wallet"
        //      ], 422));
        // }
        
        //check if sender has points
        if(!isset($data['points']) || $senderUser->wallet->points < $data['points']){
            throw new ValidationException($this,response()->json([
                 "message" => "Sender doesn't have enough points"
             ], 422));
        }

        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'points' => 'required|integer|min:0'
        ];
    }
}
