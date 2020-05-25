<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class TripStatusController extends Controller
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

        $model      = new \App\TripStatus;
        $datatable  = $model::getDataTable('id','desc','10');
        $tableDesign= $model->dataTable;
        return view(Setting.'.TripStatus.index',compact('model','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\TripStatus;
        $method         = 'create';
        $action         = 'TripStatus.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Setting.'.TripStatus.create',compact('model','method','action','modelCreator','colmd'));
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
            $this->validate($request, ['trip_status_desc_ar'=>'required|unique:trip_statuses,trip_status_desc_ar','trip_status_desc_en'=>'required|unique:trip_statuses,trip_status_desc_en',]);
            $request->request->add(['created_by' => Auth::user()->id]);
            $IP = \App\TripStatus::create($request->all());
            return redirect()->route('TripStatus.index');
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
            $model      = new \App\TripStatus;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'TripStatus.update';
            $modelShower= $model->editAdmin;
            return view(Setting.'.TripStatus.show',compact('showData','model','method','action','modelShower'));
        }else{
            return redirect()->route('TripStatus.index');
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
        $model      = new \App\TripStatus;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'TripStatus.update';
        $modelEditor= $model->editAdmin;
        return view(Setting.'.TripStatus.edit',compact('model','method','action','modelEditor'));
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
        $this->validate($request, ['trip_status_desc_ar'=>'required|unique:trip_statuses,trip_status_desc_ar,'.$id,'trip_status_desc_en'=>'required|unique:trip_statuses,trip_status_desc_en,'.$id,]);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Ip   = \App\TripStatus::find($id);
        $update = $Ip->update($request->all());
        return redirect()->route('TripStatus.index');
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
        \App\TripStatus::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
