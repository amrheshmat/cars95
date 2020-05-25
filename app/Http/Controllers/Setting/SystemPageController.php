<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use App\Http\Requests;

class SystemPageController extends Controller
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

        $model      = new \App\SystemPage;
        $datatable  = $model::getDataTable('id','desc','10');
        $tableDesign= $model->dataTable;
        return view(Setting.'.SystemPage.index',compact('model','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\SystemPage;
        $method         = 'create';
        $action         = 'SystemPage.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Setting.'.SystemPage.create',compact('model','method','action','modelCreator','colmd'));
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
            $this->validate($request, ['systemPage_pageDescriptionAR'=>'required|unique:system_pages,systemPage_pageDescriptionAR','systemPage_pageDescriptionEN'=>'required|unique:system_pages,systemPage_pageDescriptionEN','systemPage_pageURL'=>'required|unique:system_pages,systemPage_pageURL',]);
            $request->request->add(['created_by' => Auth::user()->id]);
            $IP = \App\SystemPage::create($request->all());
            return redirect()->route('SystemPage.index');
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
            $model      = new \App\SystemPage;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'SystemPage.update';
            $modelShower= $model->editAdmin;
            return view(Setting.'.SystemPage.show',compact('showData','model','method','action','modelShower'));
        }else{
            return redirect()->route('SystemPage.index');
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
        $model      = new \App\SystemPage;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'SystemPage.update';
        $modelEditor= $model->editAdmin;
        return view(Setting.'.SystemPage.edit',compact('model','method','action','modelEditor'));
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
        $this->validate($request, ['systemPage_pageDescriptionAR'=>'required|unique:system_pages,systemPage_pageDescriptionAR,'.$id,'systemPage_pageDescriptionEN'=>'required|unique:system_pages,systemPage_pageDescriptionEN,'.$id,'systemPage_pageURL'=>'required|unique:system_pages,systemPage_pageURL,'.$id,]);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Ip   = \App\SystemPage::find($id);
        $update = $Ip->update($request->all());
        return redirect()->route('SystemPage.index');
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
        \App\SystemPage::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
