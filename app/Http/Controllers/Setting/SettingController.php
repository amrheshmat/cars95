<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class SettingController extends Controller
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

        $model      = new \App\Setting;
        $datatable  = $model::getDataTable('id','desc','10');
        $tableDesign= $model->dataTable;
        $class      = 'col-md-8 col-md-offset-2';        
        return view(Setting.'.Setting.index',compact('model','datatable','tableDesign','class','colmd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Setting;
        $method         = 'create';
        $action         = 'Setting.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Setting.'.Setting.create',compact('model','method','action','modelCreator','colmd'));
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
            $this->validate($request, ['min_supported_version'=>'required','key'=>'required|unique:settings,key','order'=>'required|unique:settings,order','display_name'=>'required','value'=>'required','type'=>'required',]);
            $request->request->add(['created_by' => Auth::user()->id]);
            $IP = \App\Setting::create($request->all());
            return redirect()->route('Setting.index');
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
            $model      = new \App\Setting;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Setting.update';
            $modelShower= $model->editAdmin;
            $colmd      = 'col-md-6';
            return view(Setting.'.Setting.show',compact('showData','model','method','action','modelShower','colmd'));
        }else{
            return redirect()->route('Setting.index');
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
        $model      = new \App\Setting;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Setting.update';
        $modelEditor= $model->editAdmin;
        return view(Setting.'.Setting.edit',compact('model','method','action','modelEditor'));
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
        $this->validate($request, ['min_supported_version'=>'required','key'=>'required|unique:settings,key,'.$id,'order'=>'required|unique:settings,order,'.$id,'display_name'=>'required','value'=>'required','type'=>'required',]);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Ip   = \App\Setting::find($id);
        $update = $Ip->update($request->all());
        return redirect()->route('Setting.index');
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
        // \App\Setting::whereId($id)->delete($id);
        return Response()->json(trans('neqabty.notallowtodelete'),400);
    }
}
