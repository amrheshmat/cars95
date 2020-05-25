<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class IpController extends Controller
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

        $model      = new \App\Ip;
        $datatable  = $model::getDataTable('id','desc','10');
        $tableDesign= $model->dataTable;
        return view(Admin.'.Ip.index',compact('model','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Ip;
        $method         = 'create';
        $action         = 'Ip.store';
        $modelCreator   = $model->createAdmin;
        return view(Admin.'.Ip.create',compact('model','method','action','modelCreator'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
            $this->validate($request, ['ip'=>'required|unique:ips,ip']);
            $request->request->add(['created_by' => Auth::user()->id]);
            $IP = \App\Ip::create($request->all());
            return redirect()->route('Ip.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        if($request->ajax()){
            $model      = new \App\Ip;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Ip.update';
            $modelShower= $model->editAdmin;
            return view(Admin.'.Ip.show',compact('showData','model','method','action','modelShower'));
        }else{
            return redirect()->route('Ip.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $model      = new \App\Ip;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Ip.update';
        $modelEditor= $model->editAdmin;
        return view(Admin.'.Ip.edit',compact('model','method','action','modelEditor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, ['ip'=>'required|unique:ips,ip,'.$id]);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Ip   = \App\Ip::find($id);
        $update = $Ip->update($request->all());
        return redirect()->route('Ip.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        \App\Ip::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
