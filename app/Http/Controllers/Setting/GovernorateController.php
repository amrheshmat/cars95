<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class GovernorateController extends Controller
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

        $model      = new \App\Governorate;
        $datatable  = $model::getDataTable('governorates.id','desc','10');
        $tableDesign= $model->dataTable;
        $orderby    = 'governorates.id';
        $class      = 'col-md-4 col-md-push-4';
        return view(Setting.'.Governorate.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Governorate;
        $method         = 'create';
        $action         = 'Governorate.store';
        $modelCreator   = $model->modelcreate;
        $country_id     = \App\Country::pluck('country_desc_ar','id')->toArray();
        $colmd          = 'col-md-4';
        return view(Setting.'.Governorate.create',compact('model','method','action','modelCreator','country_id','colmd'));
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
            $this->validate($request, ['country_id'=>'required','governorate_desc_ar'=>'required|unique:governorates,governorate_desc_ar','governorate_desc_en'=>'required|unique:governorates,governorate_desc_en',]);
            $request->request->add(['created_by' => Auth::user()->id]);
            try {
                $Country = \App\Governorate::create($request->all());
            } catch (\PDOException $e) {
                abort(403, '<h3 class="text-danger">'.$e->getMessage().'.</h3>');
            
            }


            return redirect()->route('Governorate.index');
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
            $model      = new \App\Governorate;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Governorate.update';
            $modelShower= $model->modelEditor;
            $country_id = \App\Country::pluck('country_desc_ar','id')->toArray();
            return view(Setting.'.Governorate.show',compact('showData','model','method','action','modelShower','country_id'));
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
        $model      = new \App\Governorate;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Governorate.update';
        $modelEditor= $model->modelEditor;
        $colmd      = 'col-md-4';
        $country_id      = \App\Country::pluck('country_desc_ar','id')->toArray();
        return view(Setting.'.Governorate.edit',compact('model','method','action','modelEditor','colmd','country_id'));
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
        $this->validate($request, ['country_id'=>'required','governorate_desc_ar'=>'required|unique:governorates,governorate_desc_ar,'.$id,'governorate_desc_en'=>'required|unique:governorates,governorate_desc_en,'.$id,]);
        // $request->request->add(['updated_by' => Auth::user()->id]);
       
        $Governorate= \App\Governorate::find($id);
        $update     = $Governorate->update($request->all());
        return redirect()->route('Governorate.index');
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
        \App\Governorate::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
