<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class AreaController extends Controller
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

        $model      = new \App\Area;
        $datatable  = $model::getDataTable('areas.area_id','desc','10');
        $tableDesign= $model->dataTable;
        $orderby    = 'areas.area_id';
        $class      = 'col-md-4 col-md-push-4';
        return view(Setting.'.Area.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Area;
        $method         = 'create';
        $action         = 'Area.store';
        $modelCreator   = $model->modelcreate;
        $governorate_id = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
        $colmd          = 'col-md-4';
        return view(Setting.'.Area.create',compact('model','method','action','modelCreator','governorate_id','colmd'));
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
            $this->validate($request, ['governorate_id'=>'required','area_name'=>'required|unique:areas,area_name']);
            $request->request->add(['created_by' => Auth::user()->id]);
            $request->request->add(['country_id' => \App\Governorate::find($request->governorate_id)->first()->country_id ]);
            $Area = \App\Area::create($request->all());           
            return redirect()->route('Area.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->ajax()){
            $model      = new \App\Area;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Area.update';
            $modelShower= $model->modelEditor;
            $governorate_id     = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
            return view(Setting.'.Area.show',compact('showData','model','method','action','modelShower','governorate_id'));
        }else{
            return redirect()->route('Governorate.index');
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
        $model      = new \App\Area;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Area.update';
        $modelEditor= $model->modelEditor;
        $colmd      = 'col-md-4';
        $governorate_id      = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
        return view(Setting.'.Area.edit',compact('model','method','action','modelEditor','colmd','governorate_id'));



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
        $this->validate($request, ['governorate_id'=>'required','area_name'=>'required|unique:areas,area_name,'.$id.',area_id']);
        $request->request->add(['updated_by' => Auth::user()->id]);        
        $request->request->add(['country_id' => \App\Governorate::find($request->governorate_id)->first()->country_id ]);
        $Area   = \App\Area::where('area_id',$id);
        $update = $Area->update($request->except('_method','_token'));
        return redirect()->route('Area.index');
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
        \App\Area::where('area_id',$id)->delete($id);
        return Response()->json($id);
    }
}
