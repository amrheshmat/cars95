<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use Image;
use Cookie;
use Session;
// use App\Http\Requests;

class PlaceController extends Controller
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
        $model      = new \App\Place;
        $datatable  = $model::getDataTable('places.id','desc','10');
        $tableDesign= $model->dataTable;
        $class      = 'col-md-8 col-md-offset-2'; 
        return view(Setting.'.Place.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Place;
        $method         = 'create';
        $action         = 'Place.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        $governorate_id     = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
        $trip_place_type_id = \App\TripPlaceType::pluck('trip_place_type_desc_ar','id')->toArray();
        return view(Setting.'.Place.create',compact('model','method','action','modelCreator','colmd','governorate_id','trip_place_type_id'));
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
            $this->validate($request, ['name' =>'required|unique:places,name','governorate_id'=>'required|exists:governorates,id','trip_place_type_id'=>'required|exists:trip_place_types,id','uploadphotos.*'=>'image','details' =>'required','rules' =>'required']);
            $request->request->add(['created_by' => Auth::user()->id]);                
            $Place = \App\Place::create($request->all());            
            if(File::exists(public_path('/upload/Place/'.$Place->id)) == false ){File::makeDirectory(public_path('/upload/Place/'.$Place->id,0777,true));}
            
            if($request->hasfile('uploadphotos')){
                foreach($request->file('uploadphotos') as $uploadphotos){
                    $file = $uploadphotos;
                    $filename = uniqid(time().time().rand(10, 99)).".".$uploadphotos->getClientOriginalExtension();
                    $Image = \App\Image::create(['image'=>'/upload/Place/'.$Place->id.'/'.$filename,'model_id'=>$Place->id,'model_type'=>'App\Place','created_by'=>Auth::user()->id]);
                    $picture = Image::make($uploadphotos->getRealPath());
                    $picture->save(public_path().'/upload/Place/'.$Place->id.'/'.$filename,50);

                }
            }
                
            return redirect()->route('Place.index',$Place->id);
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
            $model      = new \App\Place;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Place.update';
            $modelShower= $model->showAdmin;
            $governorate_id     = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
            $trip_place_type_id = \App\TripPlaceType::pluck('trip_place_type_desc_ar','id')->toArray();
            $colmd      = 'col-md-6';
            return view(Setting.'.Place.show',compact('showData','model','method','action','modelShower','governorate_id','trip_place_type_id','colmd'));
        }else{
            return redirect()->route('Place.index');
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
        $model      = new \App\Place;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Place.update';
        $modelEditor= $model->editAdmin;
        $governorate_id     = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
        $trip_place_type_id = \App\TripPlaceType::pluck('trip_place_type_desc_ar','id')->toArray();
        return view(Setting.'.Place.edit',compact('model','method','action','modelEditor','governorate_id','trip_place_type_id'));
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
        if($request->ajax() && !empty($request->file)){
            $this->validate($request, ['file' => 'image|max:3000']);
            if(File::exists(public_path('/upload/Place/'.$id)) == false ){File::makeDirectory(public_path('/upload/Place/'.$id,0777,true));}
            $file = $request->file('file');
            $filename = uniqid(time().time().rand(10, 99)).".".$request->file->getClientOriginalExtension();
            $Image = \App\Image::create(['image'=>'/upload/Place/'.$id.'/'.$filename,'model_id'=>$id,'model_type'=>'App\Place','created_by'=>Auth::user()->id]);
            //Check picture path exists or not
            $picture = Image::make($request->file('file'));
            // $picture->resize(160, null, function ($constraint) {$constraint->aspectRatio();});
            $picture->save(public_path().'/upload/Place/'.$id.'/'.$filename,50);
            return '';
                
        }
        $this->validate($request, ['name'=>'required|unique:places,name,'.$id,'governorate_id'=>'required|exists:governorates,id','trip_place_type_id'=>'required|exists:trip_place_types,id','details' =>'required','rules' =>'required']);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Place   = \App\Place::find($id);
        $update = $Place->update($request->all());
        return redirect()->route('Place.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //remove Syndicate
        if($request->has('photoId')){
            // return Response()->json('REDA');
            \App\Image::find($id)->delete();
            return Response()->json($id);
        }
        \App\Place::whereId($id)->delete($id);
        return Response()->json($id);
    }
    // public function insertPhone($request, $id){
    //     $this->validate($request, ['phone' =>'required|number|unique:syndicate_phones,phone']);
    //     $request->request->add(['created_by'    => Auth::user()->id]);
    //     $request->request->add(['syndicate_id'  => $id]);
    //     $request->request->add(['syndicate_type'  => 'App\SubSyndicate']);
    //     $Phone = \App\SyndicatePhone::create($request->all());
    //     return Response()->json($Phone);
    // }    
}
