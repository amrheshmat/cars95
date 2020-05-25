<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use Image;
// use App\Http\Requests;

class SyndicateController extends Controller
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

        $model      = new \App\Syndicate;
        $datatable  = $model::getDataTable('id','desc','10');
        $tableDesign= $model->dataTable;
        $class      = 'col-md-12';
        return view(Setting.'.Syndicate.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\Syndicate;
        $method         = 'create';
        $action         = 'Syndicate.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        $governorate_id = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
        return view(Setting.'.Syndicate.create',compact('model','method','action','modelCreator','colmd','governorate_id'));
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
            $this->validate($request, ['syndicate_logo' => 'required|image|max:3000','syndicate_fax'=>'required','syndicate_address' =>'required','captain'=>'required','syndicate_agent'=>'required','secretary_general'=>'required','cashier'=>'required','assistant_secretary_general'=>'required','assistant_cashier'=>'required','syndicate_desc_ar' =>'required|unique:syndicates,syndicate_desc_ar','syndicate_desc_en' =>'required|unique:syndicates,syndicate_desc_en','phone.*'=>'required|unique:syndicate_phones,phone','email.*'=>'required|unique:syndicate_emails,email','governorate_id'=>'required|exists:governorates,id',]);
            $transaction = DB::transaction(function () use ($request) {
                $request->request->add(['created_by' => Auth::user()->id]);                
                $Syndicate = \App\Syndicate::create($request->all());
                // phone
                foreach ($request->phone as $key => $v){$phones []  = [ 'phone'=>$v,'syndicate_id'=>$Syndicate->id,'syndicate_type'=>'App\Syndicate','created_by'=>Auth::user()->id,'created_at'=>now(),];  }
                $syndicate_phones   = DB::table('syndicate_phones')->insert($phones);
                // email
                foreach ($request->email as $key => $v){ $email []  = [ 'email'=>$v,'syndicate_id'=>$Syndicate->id,'syndicate_type'=>'App\Syndicate','created_by'=>Auth::user()->id,'created_at'=>now(),]; }
                $syndicate_emails   = DB::table('syndicate_emails')->insert($email);
                return compact('Syndicate');

            });
            $syndicateId = $transaction['Syndicate']->id;
            if(!empty($request->file('syndicate_logo'))){
                //Check picture path exists or not
                if(File::exists(public_path('/upload/Syndicate/'.$syndicateId)) == false ){File::makeDirectory(public_path('/upload/Syndicate/'.$syndicateId,0777,true));}
                // img
                $picture = Image::make($request->file('syndicate_logo'));
                $picture->resize(160, null, function ($constraint) {$constraint->aspectRatio();});
                $picture->save(public_path().'/upload/Syndicate/'.$syndicateId.'/logo.jpg',50);
                $transaction['Syndicate']->syndicate_logo = '/upload/Syndicate/'.$syndicateId.'/logo.jpg';
                $transaction['Syndicate']->save();
            }
            return redirect()->route('Syndicate.index');
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
            $model      = new \App\Syndicate;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'Syndicate.update';
            $modelShower= $model->showAdmin;
            $governorate_id = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
            $colmd      = 'col-md-4';
            return view(Setting.'.Syndicate.show',compact('showData','model','method','action','modelShower','governorate_id','colmd'));
        }else{
            return redirect()->route('Syndicate.index');
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
        $model      = new \App\Syndicate;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Syndicate.update';
        $modelEditor= $model->editAdmin;
        $governorate_id = \App\Governorate::pluck('governorate_desc_ar','id')->toArray();
        return view(Setting.'.Syndicate.edit',compact('model','method','action','modelEditor','governorate_id'));
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
        $this->validate($request, ['syndicate_logo' => 'image|max:3000','syndicate_fax'=>'required','syndicate_address' =>'required','captain'=>'required','syndicate_agent'=>'required','secretary_general'=>'required','cashier'=>'required','assistant_secretary_general'=>'required','assistant_cashier'=>'required','syndicate_desc_ar'=>'required|unique:syndicates,syndicate_desc_ar,'.$id,'syndicate_desc_en'=>'required|unique:syndicates,syndicate_desc_en,'.$id,'governorate_id'=>'required|exists:governorates,id']);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Syndicate   = \App\Syndicate::find($id);
        $update      = $Syndicate->update($request->except('syndicate_logo'));    
        if(!empty($request->file('syndicate_logo'))){                            
            if(File::exists(public_path('/upload/Syndicate/'.$id)) == false ){File::makeDirectory(public_path('/upload/Syndicate/'.$id,0777,true));}
            $filename = uniqid(time().time().rand(10, 99)).".".$request->file('syndicate_logo')->getClientOriginalExtension();        
            $picture = Image::make($request->file('syndicate_logo'));                     
            $picture->save(public_path().'/upload/Syndicate/'.$id.'/'.$filename,50);
            $Syndicate->syndicate_logo = '/upload/Syndicate/'.$id.'/'.$filename;
            $Syndicate->save();
        }
        return redirect()->route('Syndicate.index');
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
        \App\Syndicate::whereId($id)->delete($id);
        \App\SyndicatePhone::where('syndicate_id',$id)->where('syndicate_type','App\Syndicate')->delete();
        \App\SyndicateEmail::where('syndicate_id',$id)->where('syndicate_type','App\Syndicate')->delete();
        return Response()->json($id);
    }
    public function insertPhone($request, $id){

        $this->validate($request, ['phone' =>'required|numeric|unique:syndicate_phones,phone']);
        $request->request->add(['created_by'    => Auth::user()->id]);        
        $syndicate  = \App\Syndicate::find($id);
        $Phone      = $syndicate->phones()->create($request->all());
        return Response()->json($Phone);
        
    }

    public function insertEmail($request, $id){
        $this->validate($request, ['email' =>'required|email|unique:syndicate_emails,email']);
        $request->request->add(['created_by'    => Auth::user()->id]);            
        $syndicate  = \App\Syndicate::find($id);
        $email      = $syndicate->emails()->create($request->all());
        return Response()->json($email);
    }
}
