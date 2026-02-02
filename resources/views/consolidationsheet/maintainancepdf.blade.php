<?php
  function secremove($time){
        
            $time_array = explode(':', $time);
            $hours = (int)$time_array[0];
            $minutes = (int)$time_array[1];
            $seconds = (int)$time_array[2];
             $time_div="$hours:$minutes";
            
            return $time_div;
            
    }
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
$pdf->SetTitle('MAINTENANCE');
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

$pdf->Cell(0,0, "KEY PERFORMANCE INDICATORS  - ".$years." FOR ".strtoupper($department_name),0,1,'L');

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
//$pdf->Line(325, 129, 994, 129);
/* end */
$pdf->Line(10, 150, 994, 150);
//$pdf->Line(10, 173, 994, 173);

$pdf->Line(34, 110, 34, 590);
$pdf->Line(95, 110, 95, 590);
$pdf->Line(160, 110, 160, 590);
$pdf->Line(210, 110, 210, 590);
$pdf->Line(280, 110, 280, 590);

$pdf->SetXY(8,130);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Sl.No" ,0,1,'L');


$pdf->SetXY(30,125);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');    
$pdf->MultiCell(66,8, "Product" ,0,'C');


$pdf->SetXY(95,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(65,10, "Performance Measurement",0,'L');

$pdf->SetXY(165,115);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
//$pdf->SetFillColor('0','176','240');
//$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(50,10, "Prior Year's Actual" ,0,'L');

$pdf->SetXY(215,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
//$pdf->SetFillColor('0','176','240');
//$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(66,10, "Target Current Year" ,0,'L');



$i=1; 
//dd($month);
 $x2 =160; 
 foreach($month as $key=>$value){ 
     
 $x2 = $x2+60;
 /* header x axis line */
 $pdf->Line($x2+60, 110, $x2+60, 590);
 //for($i=1;$i<=$no_of_weeks;$i++){
 /* end */
// $pdf->SetXY($x2,140);
//$pdf->SetFont('','B','9');
//$pdf->SetTextColor('0','0','0');
//$pdf->Cell(0,0,$value ,0,1,'L');
     
$pdf->SetXY($x2+70,130);
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
$z3=250;
//Machine details
//dd($breakdown_details);
//dd($rowData);



$i=1;
 $y=$pdf->getY();

$key=$key+1;
$pdf->SetXY(15,$y+115);
$pdf->SetFont('','','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $i++,0,1,'L');

$pdf->SetXY(40,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, 'Machine Maintainance' ,0,'L');

$pdf->SetXY(40,$y+150);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, 'Die Maintainance' ,0,'L');

$pdf->SetXY(95,$y+30);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "No Of Breakdown Hours" ,0,'C');

$pdf->Line($x2-765,$y+58, $z3+744, $y+58);

$pdf->SetXY(95,$y+65);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "Mean Time to Repair" ,0,'C');

$pdf->Line($x2-765,$y+86, $z3+744, $y+86);

$pdf->SetXY(95,$y+90);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "Mean Time Between Failures" ,0,'C');
$pdf->Line($x2-825,$y+118, $z3+744, $y+118);




$pdf->SetXY(95,$y+122);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "No Of Breakdown Hours" ,0,'C');

$pdf->Line($x2-765,$y+148, $z3+744, $y+148);

$pdf->SetXY(95,$y+155);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "Mean Time to Repair" ,0,'C');

$pdf->Line($x2-765,$y+176, $z3+744, $y+176);


$pdf->SetXY(95,$y+180);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,8, "Mean Time Between Failures" ,0,'C');
$oldY = $pdf->getY();
$pdf->Line($x2-825,$y+210, $z3+744, $y+210);
//$pdf->Line($x3-116,$y+55, $z3+694, $y+55);
$y=$pdf->getY();
$oldY = $pdf->getY();

/* row line */
//$pdf->Line($x3+13,$y+55, $z3+694, $y+55);
/* row line end */












//$y = $pdf->getY();

$oldY=$y;
//dd($breakdown_details);
$x=280;
foreach($month1 as $key=>$val)
{

 /* header x axis line */
 //$pdf->Line($x2+60, 110, $x2+60, 590);
 //for($i=1;$i<=$no_of_weeks;$i++){
 /* end */

$pdf->SetXY(165,170);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($no_brk_hrs_target) ,0,'L');

$pdf->SetXY(220,170);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($brk_hrs) ,0,'L');

if(isset($yr_total[$key]['brk_hrs'])) {
$pdf->SetXY($x+10,$y-165);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($yr_total[$key]['brk_hrs']),0,'L');

$pdf->SetXY(165,202);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($mttr_target) ,0,'L');

$pdf->SetXY(220,202);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($mttr_hrs) ,0,'L');


if(isset($yr_total[$key]['mttr_hrs'])) {
$pdf->SetXY($x+10,$y-132);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($yr_total[$key]['mttr_hrs']) ,0,'L');

$pdf->SetXY(165,230);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($mtbf_target) ,0,'L');

$pdf->SetXY(220,230);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($mtbf_hrs) ,0,'L');

if(isset($yr_total[$key]['mtbf_hrs']))
$pdf->SetXY($x+10,$y-105);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($yr_total[$key]['mtbf_hrs']) ,0,'L');

$x=$x+60;

}
}}
if($oldY/510>=1)
{
  
    $oldY=0;
   
    $pdf->addpage();

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

$pdf->Cell(0,0, "KEY PERFORMANCE INDICATORS  - ".$years." FOR ".strtoupper($department_name) ,0,1,'L');

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
//$pdf->Line(325, 129, 994, 129);
/* end */
$pdf->Line(10, 150, 994, 150);
//$pdf->Line(10, 173, 994, 173);

$pdf->Line(34, 110, 34, 590);
$pdf->Line(95, 110, 95, 590);
$pdf->Line(160, 110, 160, 590);
$pdf->Line(210, 110, 210, 590);
$pdf->Line(280, 110, 280, 590);

$pdf->SetXY(8,130);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Sl.No" ,0,1,'L');


$pdf->SetXY(30,125);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');    
$pdf->MultiCell(66,8, "Product" ,0,'C');


$pdf->SetXY(95,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(65,10, "Performance Measurement",0,'L');

$pdf->SetXY(165,115);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
//$pdf->SetFillColor('0','176','240');
//$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(50,10, "Prior Year's Actual" ,0,'L');

$pdf->SetXY(215,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
//$pdf->SetFillColor('0','176','240');
//$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(66,10, "Target Current Year" ,0,'L');


 /*$x2 =160; 
 foreach($month as $key=>$value){ 
     
 $x2 = $x2+60;
 /* header x axis line */
 $pdf->Line($x2+60, 110, $x2+60, 590);
 //for($i=1;$i<=$no_of_weeks;$i++){
 /* end *

$pdf->SetXY($x2+70,130);
$pdf->SetFont('','B','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,$value ,0,1,'L');
 
 } */
 

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





