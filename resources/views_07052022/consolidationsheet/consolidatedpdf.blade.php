<?php

  function secremove($time){
        
            $time_array = explode(':', $time);
            $hours = (int)$time_array[0];
            $minutes = (int)$time_array[1];
            $seconds = (int)$time_array[2];
             $time_div="$hours:$minutes";
            
            return $time_div;
            
    }
$count_data=(count($rowData));
$even=($count_data)%2;

require 'pdf/fpdf/fpdf.php';
require('pdf/fpdf/fpdf_protection.php');
//require('pdf/fpdf/polygon.php');
$pdf=new FPDF('L', 'pt', 'Legal');
//dd($breakdown_details);
//Function to convert Amount in words
function convert_number_to_words($number)
{
    
error_reporting(0);
$no = round($number);
$point = round($number - $no, 2) * 100;
$hundred = null;
$digits_1 = strlen($no);
$i = 0;
$month = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
$str = array();
$words = array('0' => '', '1' => 'One', '2' => 'Two',
'3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
'7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
'10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
'13' => 'Thirteen', '14' => 'Fourteen',
'15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
'18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
'30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
'60' => 'Sixty', '70' => 'Seventy',
'80' => 'Eighty', '90' => 'Ninety');

$digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
while ($i < $digits_1)
{
$divider = ($i == 2) ? 10 : 100;
$number = floor($no % $divider);
$no = floor($no / $divider);
$i += ($divider == 10) ? 1 : 2;
if ($number) {
$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
$str [] = ($number < 21) ? $words[$number] .
" " . $digits[$counter] . $plural . " " . $hundred
:
$words[floor($number / 10) * 10]
. " " . $words[$number % 10] . " "
. $digits[$counter] . $plural . " " . $hundred;
} else $str[] = null;
}
$str = array_reverse($str);
$result = implode('', $str);
$points = ($point) ?
"." . $words[$point / 10] . " " .
$words[$point = $point % 10] : '';
return $result . "Rupees Only";
}

//Function to convert Amount in words End

$pdf->SetFont('times','BIU');
$pdf->addpage();
$pdf->SetTitle('CONSOLIDATION SHEET');
$count=1;
$i=0;


//*********************** DECIDINGE THE PAGE ERROR OR CONTENT****////
//$month = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];

$yr=substr($years,-2);
$month=array("1"=>"JAN-".$yr,"2"=>"Feb-".$yr,"3"=>"Mar-".$yr,"4"=>"Apr-".$yr,"5"=>"May-".$yr,"6"=>"Jun-".$yr,"7"=>"Jul-".$yr,"8"=>"Aug-".$yr,"9"=>"Sept-".$yr,"10"=>"Oct-".$yr,"11"=>"Nov-".$yr,"12"=>"Dec-".$yr);
$month1 = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
//$month = ["0"=>"JAN","1"=>"FEB","2"=>"MAR","3"=>"APR","4"=>"MAY","5"=>"JUN","6"=>"JUL","7"=>"AUG","8"=>"SEPT","9"=>"OCT","10"=>"NOV","11"=>"DEC"];
$ordinates = [405,445,480,520,560,600,645,680,720,760,800,840];
if(empty($l_error))
{

//$pdf->Image(public_path().'/uploads/images/vfpl.jpg', 20, 30, 580, 820,'JPG');
//margin
$pdf->SetDrawColor(0,0,255);
$pdf->line(10,20,994,20);
$pdf->line(10, 590, 10, 20);

$pdf->line(10, 860, 994, 845);
$pdf->line(994, 20, 994, 590);       
    

//Data Line


//margin end

$pdf->Image(public_path().'/sximo/images/alpha_logos.png', 13, 22, 200, 50,'PNG');





$pdf->SetXY(300,40);
$pdf->SetFont('','B','18');
$pdf->SetTextColor('0','0','0');

$pdf->Cell(0,0, 'COOKSON INDIA PRIVATE LIMITED' ,'0','L');



$pdf->SetXY(320,60);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, 'No: 16, N.P Sidco Inducstrial Estate, Ambattur, Chennai - 600098 , India.' ,'0','L');

$pdf->SetXY(750,30);
$pdf->SetFont('','B','14');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, 'Doc.No : AIN - MAINT - FORM0002' ,'0','L');

$pdf->SetXY(750,50);
$pdf->SetFont('','B','14');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, 'Rev.No : '.$revision_no ,'0','L');

$pdf->SetXY(750,70);
$pdf->SetFont('','B','14');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, 'Rev.Date : '.$revision_date ,'0','L');

$pdf->SetXY(222,45);
$pdf->SetFont('','','10');
$pdf->SetTextColor('0','0','0');
//$pdf->MultiCell(300,10,$company_address,'0','L');
$oldY_cny=$pdf->getY();
//dd($data);
if($oldY_cny==0) $yc=70;
else $yc=$oldY_cny+5;


$pdf->SetXY(30,100);
$pdf->SetFont('','','8');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, "Year : ".$years ,0,1,'L');

  
$pdf->Line(10, 80, 994, 80);
$pdf->Line(10, 109, 994, 109);


$pdf->SetXY(300,100);
$pdf->SetFont('','B','14');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$department_name=SiteHelpers::gridDisplayView( $department_id ,'equipment_id','1:m_department_tbl:department_id:department_name') ;

$pdf->Cell(0,0, "CONSOLIDATED REPORT FOR - ".strtoupper($department_name)." ".$years ,0,1,'L');



$pdf->SetXY(660,100);
$pdf->SetFont('','','8');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('200', '0', '0');
//$pdf->Rect(20, 105, 560, 20, 'F');
//$pdf->Cell(0,0, "Department: ".$department_name ,0,1,'L');



$oldcusty=$pdf->getY();

$oldY2 = $pdf->getY();

if($oldY2==0) $y2 =220;
else $y2 = $oldY2+6;



//content lines
$pdf->SetDrawColor(0,0,255);




//red
 $pdf->SetFillColor('255', '0', '0');
 /* header color red*/
//$pdf->Rect(180, 130, 814, 20, 'F');
/* end */
//$pdf->line(380,150,870,150);
//$pdf->Line(850, 132, 850, 575);

$pdf->Line(994, 590, 10, 590);
//content lines End


$pdf->SetXY(20,259);
$pdf->SetFont('','B','10');

$pdf->SetFillColor('255','255','255',"0.52");
$pdf->SetTextColor('255','0','0');

//$pdf->Rect(11, 110, 133, 22, 'F');


$pdf->SetFillColor('255','255','0',"0.52");
$pdf->SetTextColor('255','0','0');
/* header yellow color */
//$pdf->Rect(179, 110, 813, 18, 'F');
/* end */
$pdf->SetFillColor('255','255','255',"0.52");
//$pdf->Rect(11, 130, 984, 10, 'F');



$pdf->SetFillColor('0','176','240');
//$pdf->Rect(111, 150, 33, 23, 'F');

/* headre center line*/
$pdf->Line(210, 129, 994, 129);
/* end */
$pdf->Line(10, 150, 994, 150);
//$pdf->Line(10, 173, 994, 173);

$pdf->Line(34, 110, 34, 590);
$pdf->Line(102, 110, 102, 590);
$pdf->Line(140, 110, 140, 590);
$pdf->Line(210, 110, 210, 590);

$pdf->SetXY(8,130);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Sl.No" ,0,1,'L');


$pdf->SetXY(30,125);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');    
$pdf->MultiCell(66,8, "Machine Name" ,0,'C');


$pdf->SetXY(105,115);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(30,10, "M/C ID NO",0,'L');

$pdf->SetXY(142,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
//$pdf->SetFillColor('0','176','240');
//$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(66,10, "Performance Measurement" ,0,'L');

$pdf->SetXY(220,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Month : ".$years ,0,'L');

$pdf->SetXY(935,140);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');

$pdf->Cell(0,0, "Overall" ,0,'L');


	
	


//$pdf->SetXY(130,120);
//$pdf->SetFont('','B','10');
//$pdf->SetTextColor('0','0','0');
//$pdf->Cell(0,0, "".$year ,0,1,'L');
//
//$pdf->SetXY(128,140);
//$pdf->SetFont('','B','9');
//$pdf->SetTextColor('0','0','0');
////$pdf->SetFillColor('0','176','240');
//$pdf->Rect(113, 130, 67, 19.5, 'F');
//$pdf->Cell(0,0, "Weeks" ,0,1,'L');
	
 

$i=1; 

 $x2 =160; 
 foreach($month as $key=>$value){ 
     
 $x2 = $x2+60;
 /* header x axis line */
 $pdf->Line($x2+45, 130, $x2+45, 590);
 //for($i=1;$i<=$no_of_weeks;$i++){
 /* end */
// $pdf->SetXY($x2,140);
//$pdf->SetFont('','B','9');
//$pdf->SetTextColor('0','0','0');
//$pdf->Cell(0,0,$value ,0,1,'L');

$pdf->SetXY($x2,140);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,$value ,0,1,'L');
 
 } 
$s_no=1;
$i=0;
$oldys=0;
$oldY=0;
$oldfreq=0;
$dis_amt=0;
$grand_total=0;
$x1=410;
$x2=860;
//Machine details
//dd($breakdown_details);
//dd($rowData);



$i=0;
  foreach($rowData as $key=> $value1) { 
	$machine_id=$value1->machine_id;
//dd($machine_id);
  
  $machine_name=SiteHelpers::gridDisplayView( $value1->machine_id ,'equipment_id','1:machine_tbl:machine_id:machine_name');        

$machine_number=SiteHelpers::gridDisplayView( $value1->machine_id ,'equipment_id','1:machine_tbl:machine_id:machine_number');        

 //$pdf->Line($x3, 150, $x3, 590);
    if($oldY==0) {
       $yy= $y =185;
        $x3 =127;
        $z3 = 300;
    }
else {
    $yy=$y = $oldY+40;
}
$y++;



$pdf->SetXY(15,$y);
$pdf->SetFont('','','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, ++$i,0,1,'L');

$pdf->SetXY(35,$y-5);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, $machine_name ,0,'L');

$pdf->SetXY(105,$y-5);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(35,8, $machine_number ,0,'L');







$oldY = $pdf->getY();

$pdf->SetXY(140,$y-27);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "NO.OF BREAK DOWNS" ,0,'C');

$pdf->Line($x3+13,$y-5, $z3+694, $y-5);

$pdf->SetXY(140,$y-2);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "BREAK DOWN HOURS" ,0,'C');

$pdf->Line($x3+13,$y+25, $z3+694, $y+25);

$pdf->SetXY(140,$y+32);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "AVAILABILITY HOURS" ,0,'C');

$pdf->Line($x3+13,$y+55, $z3+694, $y+55);

$pdf->SetXY(140,$y+62);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "REPAIR HOURS" ,0,'C');

$pdf->Line($x3+13,$y+85, $z3+694, $y+85);

$pdf->SetXY(140,$y+92);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "MEAN TIME TO REPAIR" ,0,'C');

$pdf->Line($x3+13,$y+118, $z3+694, $y+118);

$pdf->SetXY(140,$y+125);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "MEAN TIME TO REPAIR" ,0,'C');

$pdf->Line($x3-116,$y+150, $z3+694, $y+150);
$y=$pdf->getY();



$y = $pdf->getY();

$oldY=$y;

$x=200;
foreach($month1 as $key1=>$val1)
{
//dd($breakdown_details);
$pdf->SetXY($x+25,$yy-20);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(0,0, $breakdown_details[$machine_id][$key1]['no_brkdown'],0,'L');

$pdf->SetXY(950,$yy-20);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $total[$machine_id]['total_brkdwn'],0,'L');


if($breakdown_details[$machine_id][$key1]['brkdown_hrs']!="")
$b_hrs=secremove($breakdown_details[$machine_id][$key1]['brkdown_hrs']);

$pdf->SetXY($x+20,$yy+10);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $b_hrs ,0,'L');

if($total[$machine_id]['total_brkdwn_hours']!="")
$t_b_hrs=secremove($total[$machine_id]['total_brkdwn_hours']);

$pdf->SetXY(940,$yy+10);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,$t_b_hrs ,0,'L');

if($breakdown_details[$machine_id][$key1]['availability_hrs']!="")
$a_b_hrs=secremove($breakdown_details[$machine_id][$key1]['availability_hrs']);

$pdf->SetXY($x+20,$yy+40);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $a_b_hrs ,0,'L');
if($total[$machine_id]['total_avail_hours']!="")
$avail_b_hrs=secremove($total[$machine_id]['total_avail_hours']);

$pdf->SetXY(940,$yy+40);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,$avail_b_hrs ,0,'L');

if($breakdown_details[$machine_id][$key1]['repair_hrs']!="")
$r_b_hrs=secremove($breakdown_details[$machine_id][$key1]['repair_hrs']);

$pdf->SetXY($x+20,$yy+70);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $r_b_hrs ,0,'L');
if($total[$machine_id]['total_repair_hours']!="")
$repair_b_hrs=secremove($total[$machine_id]['total_repair_hours']);

$pdf->SetXY(940,$yy+70);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $repair_b_hrs,0,'L');

if($breakdown_details[$machine_id][$key1]['mttr']!="")
$t_b_hrs_mttr=secremove($breakdown_details[$machine_id][$key1]['mttr']);

$pdf->SetXY($x+20,$yy+100);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $t_b_hrs_mttr ,0,'L');
if($total[$machine_id]['total_mttr_hours']!="")
$mttr_b_hrs=secremove($total[$machine_id]['total_mttr_hours']);

$pdf->SetXY(940,$yy+100);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $mttr_b_hrs,0,'L');
if($breakdown_details[$machine_id][$key1]['mtbf']!="")
$mt_b_hrs=secremove($breakdown_details[$machine_id][$key1]['mtbf']);

$pdf->SetXY($x+20,$yy+130);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,$mt_b_hrs  ,0,'L');
if($total[$machine_id]['total_mtbf_hours']!="")
$m_b_hrs=secremove($total[$machine_id]['total_mtbf_hours']);

$pdf->SetXY(940,$yy+135);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,$m_b_hrs,0,'L');


$x=$x+60;
}

$y = $pdf->getY();



if($oldY/430 >=1)
{
  
    $oldY=0;
   
    $pdf->addpage();
//$pdf->SetDrawColor(255,0,0);
//$pdf->line(20,20,860,20);
//$pdf->line(20, 450, 20, 20);
//
//$pdf->line(20, 860, 860, 845);
//$pdf->line(860, 20, 860, 450); 
$pdf->SetDrawColor(0,0,255);
$pdf->line(10,20,994,20);
$pdf->line(10, 590, 10, 20);

$pdf->line(10, 860, 994, 845);
$pdf->line(994, 20, 994, 590);       
    

//Data Line


//margin end

$pdf->Image(public_path().'/sximo/images/alpha_logos.png', 13, 22, 200, 50,'PNG');





$pdf->SetXY(300,40);
$pdf->SetFont('','B','18');
$pdf->SetTextColor('0','0','0');

$pdf->Cell(0,0, 'COOKSON INDIA PRIVATE LIMITED' ,'0','L');



$pdf->SetXY(320,60);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, 'No: 16, N.P Sidco Inducstrial Estate, Ambattur, Chennai - 600098 , India.' ,'0','L');

$pdf->SetXY(750,30);
$pdf->SetFont('','B','14');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, 'Doc.No : AIN - MAINT - FORM0002' ,'0','L');

$pdf->SetXY(750,50);
$pdf->SetFont('','B','14');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, 'Rev.No : '.$revision_no ,'0','L');

$pdf->SetXY(750,70);
$pdf->SetFont('','B','14');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, 'Rev.Date : '.$revision_date ,'0','L');

$pdf->SetXY(222,45);
$pdf->SetFont('','','10');
$pdf->SetTextColor('0','0','0');
//$pdf->MultiCell(300,10,$company_address,'0','L');
$oldY_cny=$pdf->getY();
//dd($data);
if($oldY_cny==0) $yc=70;
else $yc=$oldY_cny+5;


$pdf->SetXY(30,100);
$pdf->SetFont('','','8');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$pdf->Cell(0,0, "Year : ".$years ,0,1,'L');

  
$pdf->Line(10, 80, 994, 80);
$pdf->Line(10, 109, 994, 109);

$pdf->SetXY(300,100);
$pdf->SetFont('','B','14');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('255', '0', '0');
$department_name=SiteHelpers::gridDisplayView( $department_id ,'equipment_id','1:m_department_tbl:department_id:department_name') ;

$pdf->Cell(0,0, "CONSOLIDATED REPORT FOR - ".strtoupper($department_name)." ".$years ,0,1,'L');



$pdf->SetXY(660,100);
$pdf->SetFont('','','8');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('200', '0', '0');
//$pdf->Rect(20, 105, 560, 20, 'F');
//$pdf->Cell(0,0, "Department: ".$department_name ,0,1,'L');



$oldcusty=$pdf->getY();

$oldY2 = $pdf->getY();

if($oldY2==0) $y2 =220;
else $y2 = $oldY2+6;



//content lines
$pdf->SetDrawColor(0,0,255);




//red
 $pdf->SetFillColor('255', '0', '0');
 /* header color red*/
//$pdf->Rect(180, 130, 814, 20, 'F');
/* end */
//$pdf->line(380,150,870,150);
//$pdf->Line(850, 132, 850, 575);

$pdf->Line(994, 590, 10, 590);
//content lines End


$pdf->SetXY(20,259);
$pdf->SetFont('','B','10');

$pdf->SetFillColor('255','255','255',"0.52");
$pdf->SetTextColor('255','0','0');

//$pdf->Rect(11, 110, 133, 22, 'F');


$pdf->SetFillColor('255','255','0',"0.52");
$pdf->SetTextColor('255','0','0');
/* header yellow color */
//$pdf->Rect(179, 110, 813, 18, 'F');
/* end */
$pdf->SetFillColor('255','255','255',"0.52");
//$pdf->Rect(11, 130, 984, 10, 'F');



$pdf->SetFillColor('0','176','240');
//$pdf->Rect(111, 150, 33, 23, 'F');

/* headre center line*/
$pdf->Line(210, 129, 994, 129);
/* end */
$pdf->Line(10, 150, 994, 150);
//$pdf->Line(10, 173, 994, 173);

$pdf->Line(34, 110, 34, 590);
$pdf->Line(102, 110, 102, 590);
$pdf->Line(140, 110, 140, 590);
$pdf->Line(210, 110, 210, 590);

$pdf->SetXY(8,130);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Sl.No" ,0,1,'L');


$pdf->SetXY(30,125);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');    
$pdf->MultiCell(66,8, "Machine Name" ,0,'C');


$pdf->SetXY(105,115);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(30,10, "M/C ID NO",0,'L');

$pdf->SetXY(142,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
//$pdf->SetFillColor('0','176','240');
//$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(66,10, "Performance Measurement" ,0,'L');

$pdf->SetXY(220,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Month : ".$years ,0,'L');


$pdf->SetXY(935,140);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Overall" ,0,'L');



	


//$pdf->SetXY(130,120);
//$pdf->SetFont('','B','10');
//$pdf->SetTextColor('0','0','0');
//$pdf->Cell(0,0, "".$year ,0,1,'L');
//
//$pdf->SetXY(128,140);
//$pdf->SetFont('','B','9');
//$pdf->SetTextColor('0','0','0');
////$pdf->SetFillColor('0','176','240');
//$pdf->Rect(113, 130, 67, 19.5, 'F');
//$pdf->Cell(0,0, "Weeks" ,0,1,'L');
	$x2 =160; 

 foreach($month as $key=>$value){

   
 $x2 = $x2+60;
 /* header x axis line */
$pdf->Line($x2+45, 130, $x2+45, 590);
 //for($i=1;$i<=$no_of_weeks;$i++){
 /* end */
// $pdf->SetXY($x2,140);
//$pdf->SetFont('','B','9');
//$pdf->SetTextColor('0','0','0');
//$pdf->Cell(0,0,$value ,0,1,'L');
     
$pdf->SetXY($x2,140);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,$value ,0,1,'L');

$y = $pdf->getY();
}



$y = $pdf->getY();

$oldY=$y;

 
}




  }



$pdf->SetXY(140,$y+30);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "NO.OF BREAK DOWNS" ,0,'C');

$pdf->Line($x3+13,$y+50, $z3+694, $y+50);

$pdf->SetXY(140,$y+60);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "BREAK DOWN HOURS" ,0,'C');

$pdf->Line($x3+13,$y+90, $z3+694, $y+90);

$pdf->SetXY(140,$y+97);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "AVAILABILITY HOURS" ,0,'C');

$pdf->Line($x3+13,$y+120, $z3+694, $y+120);

$pdf->SetXY(140,$y+127);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "REPAIR HOURS" ,0,'C');

$pdf->Line($x3+13,$y+150, $z3+694, $y+150);

$pdf->SetXY(140,$y+160);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "MEAN TIME TO REPAIR" ,0,'C');

$pdf->Line($x3+13,$y+185, $z3+694, $y+185);

$pdf->SetXY(140,$y+193);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "TOTAL UP TIME" ,0,'C');

$pdf->Line($x3+13,$y+220, $z3+694, $y+220);

$pdf->SetXY(140,$y+224);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "MEAN TIME TO REPAIR" ,0,'C');

$pdf->Line($x3-116,$y+248, $z3+694, $y+248);
$y=$pdf->getY();

 $x2 =160; 

if($even==0)
 {
  $pdf->SetXY(50,275);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Yearly" ,0,'L');

    foreach($yr_total as $key=>$value){  
 

 /* header x axis line */
//$pdf->Line($x2+45, 130, $x2+45, 590);
$x2 = $x2+60;
$pdf->SetXY($x2+6,170);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,$yr_total[$key]['no_brkdwn'] ,0,1,'L');

$pdf->SetXY(940,170);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $overall_brkdwn,0,'L');


if(isset($yr_total[$key]['brk_hrs'])){ 
$pdf->SetXY($x2-8,210);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['brk_hrs']) ,0,1,'L');


$pdf->SetXY(940,210);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_brkhrs),0,'L');


$pdf->SetXY($x2-8,245);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,secremove($yr_total[$key]['avail_hrs']) ,0,1,'L');

$pdf->SetXY(940,245);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_available_hrs),0,'L');

if(isset($yr_total[$key]['rep_hrs'])){ 
$pdf->SetXY($x2-8,275);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['rep_hrs']) ,0,1,'L');

$pdf->SetXY(940,275);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_rephrs),0,'L');

if(isset($yr_total[$key]['mttr_hrs'])){ 
$pdf->SetXY($x2-8,305);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['mttr_hrs']) ,0,1,'L');

$pdf->SetXY(940,305);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_mttrhrs),0,'L');

if(isset($yr_total[$key]['up_time'])){ 
$pdf->SetXY($x2-8,335);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['up_time']) ,0,1,'L');


$pdf->SetXY(940,335);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_uptime),0,'L');

if(isset($yr_total[$key]['mtbf_hrs'])){ 
$pdf->SetXY($x2-8,370);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['mtbf_hrs']) ,0,1,'L');

$pdf->SetXY(940,370);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_mtbfhrs),0,'L');

//$x2=$x2-5;
$y = $pdf->getY();
}
 
}
}
 }
 }
}
}
else{
  $pdf->SetXY(50,405);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Yearly" ,0,'L');
 foreach($yr_total as $key=>$value){  
 

 /* header x axis line */
//$pdf->Line($x2+45, 130, $x2+45, 590);
$x2 = $x2+60;
$pdf->SetXY($x2+6,350);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,$yr_total[$key]['no_brkdwn'] ,0,1,'L');

$pdf->SetXY(940,350);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $overall_brkdwn,0,'L');


if(isset($yr_total[$key]['brk_hrs'])){ 
$pdf->SetXY($x2-8,390);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['brk_hrs']) ,0,1,'L');


$pdf->SetXY(940,390);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_brkhrs),0,'L');


$pdf->SetXY($x2-8,425);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,secremove($yr_total[$key]['avail_hrs']) ,0,1,'L');

$pdf->SetXY(940,425);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_available_hrs),0,'L');

if(isset($yr_total[$key]['rep_hrs'])){ 
$pdf->SetXY($x2-8,455);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['rep_hrs']) ,0,1,'L');

$pdf->SetXY(940,455);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_rephrs),0,'L');

if(isset($yr_total[$key]['mttr_hrs'])){ 
$pdf->SetXY($x2-8,485);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['mttr_hrs']) ,0,1,'L');

$pdf->SetXY(940,485);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_mttrhrs),0,'L');

if(isset($yr_total[$key]['up_time'])){ 
$pdf->SetXY($x2-8,515);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['up_time']),0,1,'L');


$pdf->SetXY(940,515);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_uptime),0,'L');

if(isset($yr_total[$key]['mtbf_hrs'])){ 
$pdf->SetXY($x2-8,550);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');                      
$pdf->Cell(0,0,secremove($yr_total[$key]['mtbf_hrs']) ,0,1,'L');

$pdf->SetXY(940,550);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($overall_mtbfhrs),0,'L');

//$x2=$x2-5;
$y = $pdf->getY();
}
 
}
}
 }
 }
}

}
}
  
//*********************** DECIDINGE THE PAGE ERROR OR CONTENT****////
//if($print=='PRINT'){				//}

$pdf->Output('name.pdf','I');
exit;
//}else{
//$filename="uploads/purchase/PO_".$row[0]->po_number.".pdf";
//$pdf->Output($filename);

//}


//}
?>





