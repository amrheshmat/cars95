<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class SeasonController extends Controller
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

        $model      = new \App\Season;
        $datatable  = $model::getDataTable('id','desc','10');
        $tableDesign= $model->dataTable;
        return view(Setting.'.Season.index',compact('model','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Season;
        $method         = 'create';
        $action         = 'Season.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Setting.'.Season.create',compact('model','method','action','modelCreator','colmd'));
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
            $this->validate($request, ['session_desc_ar'=>'required|unique:seasons,session_desc_ar','session_desc_en'=>'required|unique:seasons,session_desc_en','season_startDate'=>'required|date|date_format:Y-m-d|after:today','season_endDate'=>'required',]);
            $request->request->add(['created_by' => Auth::user()->id]);
            $IP = \App\Season::create($request->all());
            return redirect()->route('Season.index');
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
            $model      = new \App\Season;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Season.update';
            $modelShower= $model->editAdmin;
            return view(Setting.'.Season.show',compact('showData','model','method','action','modelShower'));
        }else{
            return redirect()->route('Season.index');
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
        $model      = new \App\Season;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Season.update';
        $modelEditor= $model->editAdmin;
        return view(Setting.'.Season.edit',compact('model','method','action','modelEditor'));
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
        $this->validate($request, ['session_desc_ar'=>'required|unique:seasons,session_desc_ar,'.$id,'session_desc_en'=>'required|unique:seasons,session_desc_en,'.$id,'season_startDate'=>'required','season_endDate'=>'required',]);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Ip   = \App\Season::find($id);
        $update = $Ip->update($request->all());
        return redirect()->route('Season.index');
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
        \App\Season::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
