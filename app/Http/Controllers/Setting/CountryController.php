<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class CountryController extends Controller
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

        $model      = new \App\Country;
        $datatable  = $model::getDataTable('id','desc','10');
        $tableDesign= $model->dataTable;
        return view(Setting.'.Country.index',compact('model','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Country;
        $method         = 'create';
        $action         = 'Country.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Setting.'.Country.create',compact('model','method','action','modelCreator','colmd'));
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
            $this->validate($request, ['country_desc_ar'=>'required|unique:countries,country_desc_ar','country_desc_en'=>'required|unique:countries,country_desc_en']);
            $request->request->add(['created_by' => Auth::user()->id]);
            $IP = \App\Country::create($request->all());
            return redirect()->route('Country.index');
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
            $model      = new \App\Country;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Country.update';
            $modelShower= $model->editAdmin;
            return view(Setting.'.Country.show',compact('showData','model','method','action','modelShower'));
        }else{
            return redirect()->route('Country.index');
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
        $model      = new \App\Country;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Country.update';
        $modelEditor= $model->editAdmin;
        return view(Setting.'.Country.edit',compact('model','method','action','modelEditor'));
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
        $this->validate($request, ['country_desc_ar'=>'required|unique:countries,country_desc_ar,'.$id,'country_desc_en'=>'required|unique:countries,country_desc_en,'.$id,]);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Ip   = \App\Country::find($id);
        $update = $Ip->update($request->all());
        return redirect()->route('Country.index');
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
        \App\Country::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
