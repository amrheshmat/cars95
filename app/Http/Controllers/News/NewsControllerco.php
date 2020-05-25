<?php
namespace App\Http\Controllers\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Image;
use File;
// use App\Http\Requests;

class NewsController extends Controller
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

        $model      = new \App\News;
        $datatable  = $model::getDataTable('news.id','title','10');
        $tableDesign= $model->dataTable;
        $orderby    = 'news.id';
        $class      = 'col-md-4 col-md-push-4';
        return view(News.'.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\News;
        $method         = 'create';
        $action         = 'News.store';
        $modelCreator   = $model->modelcreate;
        $news_type_id   = \App\NewsType::pluck('type_ar','id')->toArray();
        $colmd          = 'col-md-4';
        return view(News.'.create',compact('model','method','action','modelCreator','news_type_id','colmd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $this->validate($request, ['news_type_id'=>'required','title'=>'required','desc'=>'required','source' => 'required','img' => 'required|image']);

        
            $request->request->add(['created_by' => Auth::user()->id,'main_syndicate_id' => Auth::user()->syndicate_id,]);
            try {
                $News = \App\News::create($request->all());
                $NewsId = $News->id;    
                if(File::exists(public_path('/upload/News/'.$NewsId)) == false ){File::makeDirectory(public_path('/upload/News/'.$NewsId,0777,true));}
                $picture = Image::make($request->file('img'));
                $picture->resize(400, null, function ($constraint) {$constraint->aspectRatio();});
                $picture->save(public_path().'/upload/News/'.$NewsId.'/News.jpg',50);
                $News->img = '/upload/News/'.$NewsId.'/News.jpg';
                $News->save();

            } catch (\PDOException $e) {
                abort(403, '<h3 class="text-danger">'.$e->getMessage().'.</h3>');
            
            }


            return redirect()->route('News.index');
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
            $model      = new \App\News;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'News.update';
            $modelShower= $model->modelEditor;
            $news_type_id = \App\NewsType::pluck('type_ar','id')->toArray();
            return view(News.'.show',compact('showData','model','method','action','modelShower','news_type_id'));
        }else{
            return redirect()->route('News.index');
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
        $model      = new \App\News;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'News.update';
        $modelEditor= $model->modelEditor;
        $colmd      = 'col-md-4';
        $news_type_id      = \App\NewsType::pluck('type_ar','id')->toArray();
        return view(News.'.edit',compact('model','method','action','modelEditor','colmd','news_type_id'));
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
        
        $this->validate($request, ['news_type_id'=>'required','title'=>'required','desc'=>'required','source' => 'required','img' => 'image']);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $News       = \App\News::find($id);        
        $update      = $News->update($request->except('img'));
        if($request->img){
            if(File::exists(public_path('/upload/News/'.$id)) == false ){File::makeDirectory(public_path('/upload/News/'.$id,0777,true));}
            $picture = Image::make($request->file('img'));
            $picture->resize(400, null, function ($constraint) {$constraint->aspectRatio();});
            $picture->save(public_path().'/upload/News/'.$id.'/News.jpg',50);
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
