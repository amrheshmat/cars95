<?php

namespace App\Http\Controllers\API\Wallet;

use App\User;
use App\Wallet;
use App\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\WalletTransferFormRequest;
use App\Http\Resources\Wallet as WalletResource;

class WalletController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        return new WalletResource(optional($user->wallet));
    }
    public function transfer(WalletTransferFormRequest $request,User $receiver)
    {
        $points = $request->points;
        $sender = $request->user();
        $receiver->wallet  = $receiver->wallet ?: $this->createUserWall($receiver);
        $senderWallet = $sender->wallet;
        $receiverWallet = $receiver->wallet;

        $senderWallet->points = $senderWallet->points - $points;
        $senderWallet->save();
        $receiverWallet->points = $receiverWallet->points + $points;
        $receiverWallet->save();

        return response()->json([
            'status' => 200,
            'status_message_en' => "Wallet for user [{$receiver->first_name}] updated successfully by {$points} points",
            'status_message_ar' => "Wallet for user [{$receiver->first_name}] updated successfully by {$points} points",
            'data' => []
        ], 200);
    }
    public function transferToMerchant(WalletTransferFormRequest $request,Merchant $receiver)
    {
        $points = $request->points;
        $sender = $request->user();
        $receiver->wallet  = $receiver->wallet ?: $this->createUserWallet($receiver);
        $senderWallet = $sender->wallet;
        $receiverWallet = $receiver->wallet;

        $senderWallet->points = $senderWallet->points - $points;
        $senderWallet->save();
        $receiverWallet->points = $receiverWallet->points + $points;
        $receiverWallet->save();

        return response()->json([
            'status' => 200,
            'status_message_en' => "Wallet for merchant [{$receiver->name}] updated successfully by {$points} points",
            'status_message_ar' => "Wallet for merchant [{$receiver->name}] updated successfully by {$points} points",
            'data' => []
        ], 200);
    }

    public function createUserWallet(Model $user)
    {
        $wallet = new Wallet();
        
        $wallet->fill([
            'user_id' => $user->id,
            'user_type' => $user->getMorphClass(),
            'points' => 0
        ])->save();
        
        return $wallet;
    }
}
