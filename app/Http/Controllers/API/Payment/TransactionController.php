<?php

namespace App\Http\Controllers\API\Payment;

use App\User;
use App\Transaction;
use Ramsey\Uuid\Uuid;
use App\helper\Initiation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function generateHash(Request $request)
    {
        $user = $request->user();
        $amount = $request->amount;
        $hash =  encrypt(["user_id" => $user->id, "amount" => $amount]);
        return Response()->json([
            'hash' => $hash
        ]);
    }
    public function create(Request $request, Initiation $initiation,Transaction $transaction)
    {
        //$hashData = decrypt($request->hash);
        //$user = User::findOrFail($hashData["user_id"]);
        $user = User::first();
        // $inquiryRes = $this->curl('http://18.188.152.62:3000/neqabty/inquiry',[
        //     "engineerID" => $request->engineerID,//"3308222",
        //     "paymentType" => $request->paymentType,
        // ]);
//         $inquiryRes['amount'] = 50;
        $inquiryRes['amount'] = $request->amount ? $request->amount : 50;

        if(!isset($inquiryRes['amount']) || $inquiryRes['amount'] == 0)
            return response()->json(isset($inquiryRes['Message']) ? $inquiryRes['Message'] : 'Something went wrong!', 400);

        $ref_num     = $initiation->GenerateRandomValue16();
        $transaction = $this->createPayment($user, $transaction,$inquiryRes['amount'],$ref_num,$request->all());
        $params = array(
            'senderId' => '029',
            'senderName' => 'AgriMisr',
            'password' => '1234',
            'serviceCode' => '140',
            'accountCode' => '1072',
            'accountAmount' => $inquiryRes['amount'],
            'paymentGatewayURL' => 'https://www.khales.com.eg/PSTestPayment/PaymentGatewayPages/RedirectPages/CardPaymentRequestIntiation.aspx',
            'confirmationURL' => config('app.public_server').'/api/v1/transactions/callback',//route('transactions.callback'),
            'confirmationRedirectURL' => config('app.public_server').'/api/v1/transactions/return',//route('transactions.return'),
            'certificatePath' => storage_path('certificates/InternetPaymentCrt.cer'),
            'serverIp' => '::1',
            "client_order_id" => $ref_num,
            "userUniqueIdentifier" => "11496706611149670661"
        );
        // Payment Mechanism
        $data['paymentType'] = "Card";
        $data['paymentMechanism'] = "NotSet";
        $data['channel'] = "";
        $mechanism = array(
            "type" => $data['paymentType'],
            "mechanismType" => $data['paymentMechanism'],
            "channel" => $data['channel'],
        );

        $data = $initiation->initiatePaymentRequest($params, $mechanism);
        $data['paymentGatewayURL'] = $params['paymentGatewayURL'];
        // Missing => Call webservice to send $ref_num &  $inquiryRes['amount']
        return response()->json(['data' => $data], 200);
    }

    public function return()
    {
        return "Done";
    }

    public function callback(Request $request, Initiation $initiator)
    {
        header("Response_Code: 000");
        $trxData = $initiator->silentCall($request->RequestObject, $request->SenderRequestNumber);
        \Log::debug("callback start");
        \Log::debug(serialize($trxData));
        \Log::debug("callback end");
        $transaction = Transaction::where('status','pending')->where('ref_number',$trxData['SenderRequestNumber'])->firstOrFail();
        \Log::debug($trxData);

        $transaction->status = (bool)$trxData['IsConfirmed']? 'paid' : 'rejected';
        // Service // to call 
                
        $transaction->save();
    }
    public function createPayment($user,Transaction $transaction,$amount, $ref_num,$data)
    {
        $transaction->fill([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'pending',
            'ref_number' => $ref_num,
            'organization_member_id' => isset($data['organization_member_id']) ? $data['organization_member_id'] : null,
            'membership_id' => isset($data['membership_id']) ? $data['membership_id'] : null,
            'syndicate_id' => isset($data['syndicate_id']) ? $data['syndicate_id'] : null,
            'sub_syndicate_id' => isset($data['sub_syndicate_id']) ? $data['sub_syndicate_id'] : null,
            'service_id' => isset($data['service_id']) ? $data['service_id'] : null,
            ])->save();
        return $transaction;
    }
    public function curl($url,$fields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec($ch);
        if (curl_errno($ch)) { 
            //dd(curl_error($ch)); 
        } 
        $result = json_decode($result,true);
        curl_close($ch);
        return $result;
    }
}


