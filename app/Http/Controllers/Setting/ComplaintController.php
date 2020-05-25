<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class ComplaintController extends Controller
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

        $model      = new \App\Complaint;
        $datatable  = $model::getDataTable('complaints.id','desc','10');
        $tableDesign= $model->dataTable;
        return view(Setting.'.Complaints.Complaint.index',compact('model','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $model          = new \App\Complaint;
        $method         = 'create';
        $action         = 'Complaint.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-12';
        return view(Setting.'.Complaints.Complaint.create',compact('model','method','action','modelCreator','colmd'));
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
            $this->validate($request, ['complaint_type'=>'required|unique:complaints']);
            $IP = \App\Complaint::create($request->all());
            return redirect()->route('Complaint.index');
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
            $model      = new \App\Complaint;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Complaint.update';
            $modelShower= $model->editAdmin;
            return view(Setting.'.Complaints.Complaint.show',compact('showData','model','method','action','modelShower'));
        }else{
            return redirect()->route('Complaint.index');
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
        $model      = new \App\Complaint;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Complaint.update';
        $modelEditor= $model->editAdmin;
        return view(Setting.'.Complaints.Complaint.edit',compact('model','method','action','modelEditor'));
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
        $this->validate($request, ['complaint_type'=>'required|unique:complaints']);
        $Ip   = \App\Complaint::find($id);
        $update = $Ip->update($request->all());
        return redirect()->route('Complaint.index');
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
        \App\Complaint::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
