<?php

namespace App\Http\Controllers\Admin;


use App\User;
use App\Wallet;
use App\OrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

/*  
    use DB;
*/
class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model      = new \App\Wallet;
        $datatable  = $model::getDataTable('wallets.id','desc','10');
        $tableDesign= $model->dataTable;
        $class      ="col-md-8 col-md-push-2";
        return view(Admin.'.Wallet.index',compact('model','class','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Wallet;
        $syndicates      = new \App\Syndicate;
        $method         = 'create';
        $action         = 'Wallet.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Admin.'.Wallet.create',compact('model','method','action','modelCreator','colmd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->user_type == 'user'){
            $user = User::findOrFail($request->user_id);
        }
        else{
            $user = OrganizationMember::findOrFail($request->user_id);
        }
        $this->validate($request, ['points' => 'required|integer|min:0','user_id'=>['required',Rule::unique('wallets')->where(function ($query) use($request) {
            return $query->where('user_type', $request->user_type);
        })]]);
        Wallet::create($request->only('points','user_id') + ['user_type' => $user->getMorphClass()]);
    
        return redirect()->route('Wallet.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Wallet $model)
    {
        //
        if($request->ajax()){
            $model    = new \App\Wallet;
            $modelShower= $model->createAdmin;
            return view(Admin.'.Wallet.show',compact('showData','model','modelShower'));
        }else{
            return redirect()->route('Wallet.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $model)
    {
        //
        $method     = 'edit';
        $action     = 'Wallet.update';
        $modelEditor= $model->editAdmin;
        $colmd      = 'col-md-4';
        return view(Admin.'.Wallet.edit',compact('model','method','action','modelEditor','colmd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Wallet $wallet)
    {
        if($request->user_type == 'user'){
            $user = User::findOrFail($request->user_id);
        }
        else{
            $user = OrganizationMember::findOrFail($request->user_id);
        }
        $this->validate($request, ['points' => 'required|integer|min:0','user_id'=>['required',Rule::unique('wallets')->where(function ($query) use($request,$wallet) {
            return $query->where('user_type', $request->user_type)->where('id' ,'!=', $wallet->id);
        })]]);
        $wallet->update($request->only('points','user_id') + ['user_type' => $user->getMorphClass()]);
    
        return redirect()->route('Wallet.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete($id);
        return Response()->json($id);
    }

}