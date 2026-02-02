<?php

namespace App\Http\Controllers;
//use bompending;
use Illuminate\Http\Request;
//dd('ghgjh');
class SparereportController extends Controller
{
    public function __construct()
	{
		$this->data=array();
                 $this->data['urlmenu']=$this->indexs(); 
		$this->data['pageMethod']=\Request::route()->getName();
		$this->data['pageFormtype']='ajax';
	}

		public function index(){

		return view('sparereport.table',$this->data);
		
    }
    
    public function qohreport(Request $request){
        
     $spare =  \DB::select("select spares_name,spare_quantity from m_spares_t ");
     //print_r( $this->data['sparer']);exit();
     return view('sparequantity.report')->with(compact('spare'));
        
    }
    public function getqohreportData(){
        
           $wh='';
           
        if(isset($_GET['pq_filter']))
		{
		$data=json_decode($_GET['pq_filter']);
		$data=$data->data;
	    $wh.=$this->pqgridsearchsum('sp1',$data);
      }

       $loc=\Session::get('location');

          $wh1='';

    $wh1.='and  machine_hdr_t.location_id='.$loc;
  //  dd($wh1);
        $page = $_GET['pq_curpage'];
        $limit = $_GET['pq_rpp'];
        $sidx='';
        if (!$sidx)
            $sidx = 1;
              $result = \DB::select("select * from (SELECT
               m_spares_t.spares_name,
               m_spares_t.spare_quantity
               from m_spares_t 
               where 1=1  group by m_spares_t.spares_id ) as sp1 where 1=1 $wh ");
     //  dd($result);
         $count = count($result); 
		//dd($count);
		if( $count > 0 && $limit > 0)
		{
		$total_pages = ceil($count/$limit);
		} else {
		$total_pages = 0;
		}
		if ($page > $total_pages)
		$page=$total_pages;
		$start = $limit*$page - $limit;
		if($start <0) $start = 0;

    
 $SQL = "select * from (SELECT
               m_spares_t.spares_name,
               m_spares_t.spare_quantity
               from m_spares_t 
               where 1=1  group by m_spares_t.spares_id ) as sp1 where 1=1 $wh  ORDER BY $sidx  LIMIT $start , $limit";

 $download_SQL="select * from (SELECT
               m_spares_t.spares_name,
               m_spares_t.spare_quantity
               from m_spares_t 
               where 1=1  group by m_spares_t.spares_id ) as sp1 where 1=1 $wh ORDER BY $sidx  ";

 $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
    
		$result = \DB::select( $SQL );
		//dd($result);
		$responce->rows[]='';
		$responce->data=$result;
		$responce->curPage = $page;
		$responce->total = $total_pages;
		$responce->totalRecords = $count;
		echo json_encode($responce);
        
    }

    public function getsparerptData(){

        $wh='';
           
        if(isset($_GET['pq_filter']))
		{
		$data=json_decode($_GET['pq_filter']);
		$data=$data->data;
	    $wh.=$this->pqgridsearchsum('sp1',$data);
      }

       $loc=\Session::get('location');

          $wh1='';

    $wh1.='and  machine_hdr_t.location_id='.$loc;  
  //  dd($wh1);
        $page = $_GET['pq_curpage'];
        $limit = $_GET['pq_rpp'];
        $sidx='';
        if (!$sidx)
            $sidx = 1;
              $result = \DB::select("select * from (SELECT
               ma_department_t.department_id,
               ma_department_t.department_name,
               m_spares_t.spares_name,
               m_spares_t.spare_quantity,
               machine_hdr_t.machine_name,
               b_maintenance_t_lines.qty
               from b_maintenance_t_lines 
               left join m_spares_t on(b_maintenance_t_lines.spares_id=m_spares_t.spares_id)
               left join ma_department_t on(ma_department_t.department_id=m_spares_t.department_id)
               left join machine_hdr_t on(machine_hdr_t.department_id=m_spares_t.department_id)
               where 1=1 $wh1  group by b_maintenance_t_lines.bm_lines_id ) as sp1 where 1=1 $wh ");
     //  dd($result);
         $count = count($result); 
		//dd($count);
		if( $count > 0 && $limit > 0)
		{
		$total_pages = ceil($count/$limit);
		} else {
		$total_pages = 0;
		}
		if ($page > $total_pages)
		$page=$total_pages;
		$start = $limit*$page - $limit;
		if($start <0) $start = 0;

    
 $SQL = "select * from (SELECT
               ma_department_t.department_id,
               ma_department_t.department_name,
               m_spares_t.spares_name,
               m_spares_t.spare_quantity,
               machine_hdr_t.machine_name,
               b_maintenance_t_lines.qty
               from b_maintenance_t_lines 
               left join m_spares_t on(b_maintenance_t_lines.spares_id=m_spares_t.spares_id)
               left join ma_department_t on(ma_department_t.department_id=m_spares_t.department_id)
               left join machine_hdr_t on(machine_hdr_t.department_id=m_spares_t.department_id)
               where 1=1 $wh1 group by b_maintenance_t_lines. bm_lines_id ) as sp1 where 1=1 $wh  ORDER BY $sidx  LIMIT $start , $limit";

 $download_SQL="select * from (SELECT
               ma_department_t.department_id,
               ma_department_t.department_name,
               m_spares_t.spares_name,
               m_spares_t.spare_quantity,
               machine_hdr_t.machine_name,
               b_maintenance_t_lines.qty
               from b_maintenance_t_lines 
               left join m_spares_t on(b_maintenance_t_lines.spares_id=m_spares_t.spares_id)
               left join ma_department_t on(ma_department_t.department_id=m_spares_t.department_id)
               left join machine_hdr_t on(machine_hdr_t.department_id=m_spares_t.department_id)
               where 1=1 $wh1  group by b_maintenance_t_lines. bm_lines_id ) as sp1 where 1=1 $wh ORDER BY $sidx  ";

 $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
          
 
	   	
		$result = \DB::select( $SQL );
		//dd($result);
		$responce->rows[]='';
		$responce->data=$result;
		$responce->curPage = $page;
		$responce->total = $total_pages;
		$responce->totalRecords = $count;
		echo json_encode($responce);
	}

}
