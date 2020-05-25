<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class NewsTypeController extends Controller
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

        $model      = new \App\NewsType;
        $datatable  = $model::getDataTable('id','desc','10');
        $tableDesign= $model->dataTable;
        return view(Setting.'.NewsType.index',compact('model','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\NewsType;
        $method         = 'create';
        $action         = 'NewsType.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Setting.'.NewsType.create',compact('model','method','action','modelCreator','colmd'));
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
            $this->validate($request, ['type_ar'=>'required|unique:news_types,type_ar','type_en'=>'required|unique:news_types,type_en',]);
            $request->request->add(['created_by' => Auth::user()->id]);
            $IP = \App\NewsType::create($request->all());
            return redirect()->route('NewsType.index');
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
            $model      = new \App\NewsType;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'NewsType.update';
            $modelShower= $model->editAdmin;
            return view(Setting.'.NewsType.show',compact('showData','model','method','action','modelShower'));
        }else{
            return redirect()->route('NewsType.index');
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
        $model      = new \App\NewsType;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'NewsType.update';
        $modelEditor= $model->editAdmin;
        return view(Setting.'.NewsType.edit',compact('model','method','action','modelEditor'));
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
        $this->validate($request, ['type_ar'=>'required|unique:news_types,type_ar,'.$id,'type_en'=>'required|unique:news_types,type_en,'.$id,]);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Ip   = \App\NewsType::find($id);
        $update = $Ip->update($request->all());
        return redirect()->route('NewsType.index');
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
        \App\NewsType::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
