<?php

namespace App\Http\Controllers;

use App\Timeformats;
use Illuminate\Http\Request;

class TimeformatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
		 $table=\DB::table('time_formats_tbl')->get();
	     $this->data['datas'] = json_encode($table);  //dd( $this->data['datas']);
		$this->data['pageMethod']='timeformats';
		  return view('timeformats.table',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    { 
		if(isset($id))
		{
		  $timefmdata = Timeformats::find($id);
		  $this->data['timefmdata']=$timefmdata;  
			return view('timeformats.form',$this->data);
		}
		$this->data['return_url']='timeformats';		
				
        return view('timeformats.form',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    { 
        $timeformatsdata = new Timeformats; 
		$edit_id = $_POST['time_formats_id'];
		if($_POST['time_formats_id']=='')
		{
			$timeformatsdata->php_format=$request->php_format; 
			$timeformatsdata->js_format=$request->js_format; 
			$timeformatsdata->display_format=$request->display_format; 

			$timeformatsdata->save();

			$id = $request->time_formats_id;
			return response()->json(array('status' => 'success', 'message' => 'Saved Successfully','id' => $id));
		}
		else
		{  
			$timefor['php_format']=$request->php_format; 
			$timefor['js_format']=$request->js_format; 
			$timefor['display_format']=$request->display_format; 
			$timefor['created_by']=\Session::get('id');
            $timefor['updated_by']=\Session::get('id');
            $timefor['updated_at']=date('Y-m-d h:s:i');
            $timefor['created_at']=date('Y-m-d h:s:i');
            $timefor['organization_id']=\Session::get('organization');
            $timefor['location_id']=\Session::get('location');
            $timefor['company_id']=\Session::get('companyid');

			$update = \DB::table('time_formats_tbl')->where('time_formats_id',$edit_id)->update($timefor);

			return response()->json(array('status' => 'success', 'message' => 'Updated Successfully','id' => $edit_id));
		}
		
		return redirect('timeformats');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Timeformats  $timeformats
     * @return \Illuminate\Http\Response
     */
    public function gettimeformatsData()
	{
	       //dd("ss");
		$wh='';
		if($_GET['_search']=='true')
		{
		  $wh=$this->jqgridsearch('time_formats_tbl',$_GET['filters']);
		}
		$page=$_GET['page'];
		$limit = $_GET['rows']; //dd($limit);
		$sidx = $_GET['sidx']; //dd($sidx);
		$sord = $_GET['sord'];

		if(!$sidx)$sidx=1;


		   $result = \DB::select("SELECT COUNT(time_formats_id) AS count FROM time_formats_tbl where 1=1 $wh");
			$count = $result[0]->count;

		if($count > 0 && $result > 0)
		{
		  $total_pages = ceil($count/$limit);
		}
		else
		{
		  $total_pages =0;
		}

		if($page > $total_pages) $page=$total_pages;

		$start = $limit*$page - $limit;

		if($start <0) $start = 0;
		$SQL = "SELECT time_formats_id,php_format,js_format,display_format FROM time_formats_tbl where 1=1 $wh ORDER BY $sidx $sord LIMIT $start , $limit";
		

		$result = \DB::select($SQL);

		$responce->rows[]='';
		$responce->rows=$result;
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;

		echo json_encode($responce);


	}

	 /*Harish Purpose for duplicate check*/
    public function timeformatcheck(Request $request)
    {
        $edit_id = $_REQUEST['edit_id'];
        if($edit_id == '')
            $group=\DB::table('time_formats_tbl')->where('php_format',$_REQUEST['php_format'],'js_format', $_REQUEST['js_format'],'display_format', $_REQUEST['display_format'])->get();
        else
        {
            $whereData = [['php_format', $_REQUEST['php_format']],['js_format', $_REQUEST['js_format']],['display_format', $_REQUEST['display_format']],['time_formats_id', '!=', $edit_id]];

            $group=\DB::table('time_formats_tbl')->where($whereData)->get();
        }
        
    	// dd($group);
        if(count($group)>0)
            return 1;
        else
            return 0;


    }

	public function timeformatdelete($id=null)
    {
        $count=0;
        if($count <= 0)
        {
            $query = \DB::table('time_formats_tbl')->where('time_formats_id',$id)->delete();
            if($query)
            {
                return 0;
            }
            else
            {
                return 1;
            }

        }
        else
        {
            return 2;
        }
    }

}
