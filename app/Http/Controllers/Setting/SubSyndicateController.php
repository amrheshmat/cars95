<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use Image;
// use App\Http\Requests;

class SubSyndicateController extends Controller
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
        
        $model      = new \App\SubSyndicate;
        $datatable  = $model::getDataTable('sub_syndicates.id','desc','10');
        $tableDesign= $model->dataTable;
        $class      = 'col-md-12';
        return view(Setting.'.SubSyndicate.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\SubSyndicate;
        $method         = 'create';
        $action         = 'SubSyndicate.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        $sub_governorate_id = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
        $syndicate_id   = \App\Syndicate::pluck('syndicate_desc_ar','id')->toArray();
        return view(Setting.'.SubSyndicate.create',compact('model','method','action','modelCreator','colmd','sub_governorate_id','syndicate_id'));
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
            $this->validate($request, ['sub_syndicate_logo' => 'required|image|max:3000','sub_syndicate_address' =>'required','sub_syndicate_fax'=>'required','sub_captain'=>'required','sub_syndicate_agent'=>'required','sub_secretary_general'=>'required','sub_cashier'=>'required','sub_assistant_secretary_general'=>'required','sub_assistant_cashier'=>'required','sub_syndicate_name_ar' =>'required|unique:sub_syndicates,sub_syndicate_name_ar','sub_syndicate_name_en' =>'required|unique:sub_syndicates,sub_syndicate_name_en','phone.*'=>'required|unique:syndicate_phones,phone','email.*'=>'required|unique:syndicate_emails,email','sub_governorate_id'=>'required|exists:governorates,id','syndicate_id'=>'required|exists:syndicates,id',]);
            $transaction = DB::transaction(function () use ($request) {
                $request->request->add(['created_by' => Auth::user()->id]);                
                $SubSyndicate = \App\SubSyndicate::create($request->all());
                // phone
                foreach ($request->phone as $key => $v){$phones []  = [ 'phone'=>$v,'syndicate_id'=>$SubSyndicate->id,'syndicate_type'=>'App\SubSyndicate','created_by'=>Auth::user()->id,'created_at'=>now(),];  }
                $syndicate_phones   = DB::table('syndicate_phones')->insert($phones);
                // email
                foreach ($request->email as $key => $v){ $email []  = [ 'email'=>$v,'syndicate_id'=>$SubSyndicate->id,'syndicate_type'=>'App\SubSyndicate','created_by'=>Auth::user()->id,'created_at'=>now(),]; }
                $syndicate_emails   = DB::table('syndicate_emails')->insert($email);
                return compact('SubSyndicate');

            });
            $SubSyndicateId = $transaction['SubSyndicate']->id;
                if(!empty($request->file('sub_syndicate_logo'))){
                //Check picture path exists or not
                if(File::exists(public_path('/upload/SubSyndicate/'.$SubSyndicateId)) == false ){File::makeDirectory(public_path('/upload/SubSyndicate/'.$SubSyndicateId,0777,true));}
                // img
                $picture = Image::make($request->file('sub_syndicate_logo'));
                $picture->resize(160, null, function ($constraint) {$constraint->aspectRatio();});
                $picture->save(public_path().'/upload/SubSyndicate/'.$SubSyndicateId.'/logo.jpg',50);            
                $transaction['SubSyndicate']->sub_syndicate_logo = '/upload/SubSyndicate/'.$SubSyndicateId.'/logo.jpg';
                $transaction['SubSyndicate']->save();
            }
            return redirect()->route('SubSyndicate.index');
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
            $model      = new \App\SubSyndicate;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'SubSyndicate.update';
            $modelShower= $model->showAdmin;
            $sub_governorate_id = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
            $syndicate_id   = \App\Syndicate::pluck('syndicate_desc_ar','id')->toArray();
            $colmd          = 'col-md-4';
            return view(Setting.'.SubSyndicate.show',compact('showData','model','method','action','modelShower','sub_governorate_id','syndicate_id','colmd'));
        }else{
            return redirect()->route('SubSyndicate.index');
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
        $model      = new \App\SubSyndicate;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'SubSyndicate.update';
        $modelEditor= $model->editAdmin;
        $sub_governorate_id = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
        $syndicate_id   = \App\Syndicate::pluck('syndicate_desc_ar','id')->toArray();
        return view(Setting.'.SubSyndicate.edit',compact('model','method','action','modelEditor','sub_governorate_id','syndicate_id'));
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
        // Insert Phone
        if($request->ajax() && !empty($request->phone)){
            return $this->insertPhone($request, $id);
        }
        // Insert email
        if($request->ajax() && !empty($request->email)){
            return $this->insertEmail($request, $id);
        }
        
        //        
        $this->validate($request, ['sub_syndicate_logo' => 'image','sub_syndicate_address' =>'required','sub_captain'=>'required','sub_syndicate_agent'=>'required','sub_secretary_general'=>'required','sub_cashier'=>'required','sub_assistant_secretary_general'=>'required','sub_assistant_cashier'=>'required','sub_syndicate_fax'=>'required','sub_syndicate_name_ar'=>'required|unique:sub_syndicates,sub_syndicate_name_ar,'.$id,'sub_syndicate_name_en'=>'required|unique:sub_syndicates,sub_syndicate_name_en,'.$id,'sub_governorate_id'=>'required|exists:governorates,id','syndicate_id'=>'required|exists:syndicates,id',]);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $SubSyndicate   = \App\SubSyndicate::find($id);        
        $update         = $SubSyndicate->update($request->except('sub_syndicate_logo'));
        if(!empty($request->file('sub_syndicate_logo'))){                
            //Check picture path exists or not
            if(File::exists(public_path('/upload/SubSyndicate/'.$id)) == false ){File::makeDirectory(public_path('/upload/SubSyndicate/'.$id,0777,true));}
            $filename = uniqid(time().time().rand(10, 99)).".".$request->file('sub_syndicate_logo')->getClientOriginalExtension();        
            $picture = Image::make($request->file('sub_syndicate_logo'));
            // $picture->resize(160, null, function ($constraint) {$constraint->aspectRatio();});            
            $picture->save(public_path().'/upload/SubSyndicate/'.$id.'/'.$filename,50);
            $SubSyndicate->sub_syndicate_logo = '/upload/SubSyndicate/'.$id.'/'.$filename;
            $SubSyndicate->save();
        }
        return redirect()->route('SubSyndicate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //Remove Phone
        if(!empty($request->phone)){
            \App\SyndicatePhone::find($id)->delete($id);
            return Response()->json('phone-'.$id);    
        }
        // remove email
        if(!empty($request->email)){
            \App\SyndicateEmail::find($id)->delete($id);
            return Response()->json('email-'.$id);    
        }
        //remove Syndicate
        \App\SubSyndicate::whereId($id)->delete($id);
        \App\SyndicatePhone::where('syndicate_id',$id)->where('syndicate_type','App\SubSyndicate')->delete();
        \App\SyndicateEmail::where('syndicate_id',$id)->where('syndicate_type','App\SubSyndicate')->delete();
        return Response()->json($id);
    }
    
    public function insertPhone($request, $id){
        $this->validate($request, ['phone' =>'required|numeric|unique:syndicate_phones,phone']);
        $request->request->add(['created_by'    => Auth::user()->id]);
        $syndicate  = \App\SubSyndicate::find($id);
        $Phone      = $syndicate->phones()->create($request->all());
        return Response()->json($Phone);
    }

    public function insertEmail($request, $id){
        $this->validate($request, ['email' =>'required|email|unique:syndicate_emails,email']);
        $request->request->add(['created_by'    => Auth::user()->id]);            
        $syndicate  = \App\SubSyndicate::find($id);
        $email      = $syndicate->emails()->create($request->all());
        return Response()->json($email);
    }
}
