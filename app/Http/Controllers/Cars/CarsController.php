<?php

namespace App\Http\Controllers\Cars;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use File;
use Image;
class CarsController extends Controller
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

        $model      = new \App\Cars;
        $datatable  = $model::getDataTable('Cars.id','title','10');
        $tableDesign= $model->dataTable;
        $orderby    = 'Cars.id';
        $class      = 'col-md-4 col-md-push-4';
        return view(Cars.'.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Cars;
        $method         = 'create';
        $action         = 'Cars.store';
        $modelCreator   = $model->modelcreate;
        $colmd          = 'col-md-4';
        return view(Cars.'.create',compact('model','method','action','modelCreator','colmd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //,'','','','','',''
            $this->validate($request, ['car_name'=>'required','car_price'=>'required','car_model'=>'required','car_type' => 'required','car_desc' => 'required','car_img' => 'required|image']);

         
            
           $request->request->add(['created_by' => Auth::user()->id]);
            try {
                $News = \App\Cars::create($request->all());
                $NewsId = $News->id;    
                if(File::exists(public_path('/images/upload/'.$NewsId)) == false ){File::makeDirectory(public_path('/images/upload/'.$NewsId.'/',0777,true));}
               // $picture = Image::make($request->file('img'));
                //$picture->resize(400, null, function ($constraint) {$constraint->aspectRatio();});
                $imagLink   = '/images/upload/'.$NewsId.'/'.time().'.'.$request->car_img->getClientOriginalExtension();
                move_uploaded_file($request->car_img,public_path().$imagLink);
                $News->car_img =  $imagLink  ;
                $News->save();
                    

            } catch (\PDOException $e) {
                abort(403, '<h3 class="text-danger">'.$e->getMessage().'.</h3>');
            
            }


            return redirect()->route('Cars.index');
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
            $model      = new \App\Cars;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Cars.update';
            $modelShower= $model->modelEditor;
            return view(Cars.'.show',compact('showData','model','method','action','modelShower',));
        }else{
            return redirect()->route('Cars.index');
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
        $model      = new \App\Cars;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Cars.update';
        $modelEditor= $model->modelEditor;
        $colmd      = 'col-md-4';
        return view(Cars.'.edit',compact('model','method','action','modelEditor','colmd'));
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
        
        $this->validate($request, ['car_name'=>'required','car_price'=>'required','car_model'=>'required','car_type' => 'required','car_desc' => 'required','car_img' => 'required|image']);
          $request->request->add(['updated_by' => Auth::user()->id]);
        $News       = \App\Cars::find($id);        
        $update      = $News->update($request->except('img'));
        if($request->img){
            if(File::exists(public_path('/images/upload/')) == false ){File::makeDirectory(public_path('/images/upload/',0777,true));}
            $imagLink   = '/images/upload/'.$NewsId.'/'.time().'.'.$request->car_img->getClientOriginalExtension();
            move_uploaded_file($request->car_img,public_path().$imagLink);
            $News->car_img =  $imagLink  ;
        }

        return redirect()->route('News.index');
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
        \App\News::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
