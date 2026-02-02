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
$pdf->SetTitle('MAINTENANCE PPT');
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

$pdf->Cell(0,0, "Machine Maintenance Monitoring - ".$years." FOR ".strtoupper($department_name)." " ,0,1,'L');

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
//$pdf->Line(210, 129, 994, 129);
$pdf->Line(70, 145, 994, 145);
/* end */
$pdf->Line(10, 185, 994, 185);
//$pdf->Line(10, 173, 994, 173);
/* header vertical sub line preventive maintainance */
$pdf->Line(205, 145, 205, 185);
$pdf->Line(265, 145, 265, 185);
$pdf->Line(312, 145, 312, 185);
/* end */
/* header vertical sub line Breakdown */
$pdf->Line(420, 145, 420, 185);
/* end */
/* header vertical sub line Breakdown Hours */
$pdf->Line(540, 145, 540, 185);
/* end */
/* header vertical sub line Repair Time */
$pdf->Line(660, 145, 660, 185);
/* end */
/* header vertical sub line Mean Time To Repair */
$pdf->Line(785, 145, 785, 185);
/* end */
/* header vertical sub line Mean Time Between Failures */
$pdf->Line(920, 145, 920, 185);
/* end */


/* end */
/* header vertical line */
$pdf->Line(70, 110, 70, 590);
$pdf->Line(145, 110, 145, 185);
$pdf->Line(360, 110, 360, 185);
$pdf->Line(480, 110, 480, 185);
$pdf->Line(600, 110, 600, 185);
$pdf->Line(720, 110, 720, 185);
$pdf->Line(850, 110, 850, 185);
//$pdf->Line(95, 110, 95, 590);
//$pdf->Line(140, 110, 140, 590);
//$pdf->Line(210, 110, 210, 590);
/* end */
$pdf->SetXY(22,145);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Plant" ,0,1,'L');

$pdf->SetXY(15,220);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Wire Plant" ,0,1,'L');

//wire plant empty line
$pdf->Line(70, 210, 994, 210);
/* end */


/* header vertical sub line preventive maintainance */


//$pdf->Line(145, 250, 145, 210);
//$pdf->Line(360, 250, 360, 210);
//$pdf->Line(480, 250, 480, 210);
//$pdf->Line(600, 250, 600, 210);
//$pdf->Line(720, 250, 720, 210);
//$pdf->Line(850, 250, 850, 210);

//$pdf->Line(205, 250, 205, 210);
//$pdf->Line(265, 250, 265, 210);
//$pdf->Line(312, 250, 312, 210);
/* end */
/* header vertical sub line Breakdown */
//$pdf->Line(420, 250, 420, 210);
/* end */
/* header vertical sub line Breakdown Hours */
//$pdf->Line(540, 250, 540, 210);
/* end */
/* header vertical sub line Repair Time */
//$pdf->Line(660, 250, 660, 210);
/* end */
/* header vertical sub line Mean Time To Repair */
//$pdf->Line(785, 250, 785, 210);
/* end */
/* header vertical sub line Mean Time Between Failures */
//$pdf->Line(920, 250, 920, 210);

/* end */





$pdf->SetXY(75,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');    
$pdf->MultiCell(66,8, "Year : ".$years,0,'C');


$pdf->SetXY(160,124);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(0,0, "Preventive Maintainance Complains Score",0,'L');

$pdf->SetXY(390,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(66,10, "Breakdown" ,0,'L');

$pdf->SetXY(500,125);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(0,0, "Breakdown Hours" ,0,'L');

$pdf->SetXY(630,125);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(0,0, "Repair Time" ,0,'L');

$pdf->SetXY(755,114);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(66,12, "Mean Time To Repair" ,0,'L');

$pdf->SetXY(870,114);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(100,12, "Mean Time Between Failures" ,0,'L');


/* month */
$pdf->SetXY(85,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Month" ,0,'L');
/* end */	

$pdf->SetXY(150,155);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "No Of MAchine",0,'L');

$pdf->SetXY(210,155);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Actual PM Done",0,'L');

$pdf->SetXY(270,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(320,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Rating",0,'L');

$pdf->SetXY(370,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(425,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "No of BD",0,'L');

$pdf->SetXY(490,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(550,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "BD Hrs",0,'L');

$pdf->SetXY(610,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(675,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "RT",0,'L');

$pdf->SetXY(730,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(795,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(40,10, "MTTR In Hrs",0,'L');

$pdf->SetXY(865,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(940,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(40,10, "MTBF In Hrs",0,'L');




$s_no=1;
$i=0;
$oldys=0;
$oldY=0;
$oldfreq=0;
$dis_amt=0;
$grand_total=0;
$x1=410;
$x2=860;
$x5=110;


     

//$y = $pdf->getY();

//$oldY=$y;
$s_no=1;
$i=0;
$oldys=0;
$oldY=0;
$oldfreq=0;
$dis_amt=0;
$grand_total=0;
$x1=410;
$x=860;
//$x=220;
foreach($month1 as $key1=>$val)
{
 //$sno=$key1+1;
   	$pdf->Line($x2-715, 211, $x2-715, 590);
	$pdf->Line($x2-655, 211, $x2-655, 590);
 	$pdf->Line($x2-595, 211, $x2-595, 590);
 	$pdf->Line($x2-548, 211, $x2-548, 590);
	$pdf->Line($x2-501, 211, $x2-501, 590);
	$pdf->Line($x2-440, 211, $x2-440, 590);
	$pdf->Line($x2-380, 211, $x2-380, 590);
	$pdf->Line($x2-320, 211, $x2-320, 590);
	$pdf->Line($x2-260, 211, $x2-260, 590);
	$pdf->Line($x2-200, 211, $x2-200, 590);
	$pdf->Line($x2-140, 211, $x2-140, 590);
	$pdf->Line($x2-75, 211, $x2-75, 590);
	$pdf->Line($x2-10, 211, $x2-10, 590);
	$pdf->Line($x2+60, 211, $x2+60, 590);
 
    if($oldY==0) {
        $y =175	;
        $x3 =150;
        $z3 =300;
    }
else {
    $y = $oldY-12;

}

$pdf->SetXY(90,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $val ,0,'L');
if(isset($pm_no_mac)){
$pdf->SetXY(165,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $pm_no_mac ,0,'L');
}
 if(isset($pm_done[$val])){
$pdf->SetXY(228,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $pm_done[$val] ,0,'L');
}
$pdf->SetXY(275,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "100%" ,0,'L');

$pdf->SetXY(320,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $pm_rating[$val] ,0,'L');

$pdf->SetXY(380,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $no_brk_target,0,'L');
if(isset($yr_total[$key1]['no_brkdwn'])) {
$pdf->SetXY(445,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, $yr_total[$key1]['no_brkdwn'] ,0,'L');
}
$pdf->SetXY(490,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($no_brk_hrs_target) ,0,'L');
if(isset($yr_total[$key1]['brk_hrs'])) {
$pdf->SetXY(550,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($yr_total[$key1]['brk_hrs']),0,'L');
}
$pdf->SetXY(610,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($no_repair_hrs_target),0,'L');
if(isset($yr_total[$key1]['rep_hrs'])) {
$pdf->SetXY(670,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($yr_total[$key1]['rep_hrs']) ,0,'L');
}
$pdf->SetXY(735,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($mttr_target) ,0,'L');
if(isset($yr_total[$key1]['mttr_hrs'])) {
$pdf->SetXY(798,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0,secremove($yr_total[$key1]['mttr_hrs']) ,0,'L');
}
$pdf->SetXY(865,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($mtbf_target) ,0,'L');
if(isset($yr_total[$key1]['mtbf_hrs'])) {
$pdf->SetXY(930,$y+55);
$pdf->SetFont('','','9');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, secremove($yr_total[$key1]['mtbf_hrs']) ,0,'L');
}
$y = $pdf->getY();
$oldY = $pdf->getY();
$oldY2 = $pdf->getY();
//$pdf->Line($x3-150,$y+15, $z3+700, $y+15);
$pdf->Line($x3-80,$y+15, $z3+694, $y+15);
$y++;


















if($oldY/510 >=1)
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

$pdf->Cell(0,0, "Machine Maintenance Monitoring - ".$years." FOR ".strtoupper($department_name)." " ,0,1,'L');

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
//$pdf->Line(210, 129, 994, 129);
$pdf->Line(70, 145, 994, 145);
/* end */
$pdf->Line(10, 185, 994, 185);
//$pdf->Line(10, 173, 994, 173);
/* header vertical sub line preventive maintainance */
$pdf->Line(205, 145, 205, 185);
$pdf->Line(265, 145, 265, 185);
$pdf->Line(312, 145, 312, 185);
/* end */
/* header vertical sub line Breakdown */
$pdf->Line(420, 145, 420, 185);
/* end */
/* header vertical sub line Breakdown Hours */
$pdf->Line(540, 145, 540, 185);
/* end */
/* header vertical sub line Repair Time */
$pdf->Line(660, 145, 660, 185);
/* end */
/* header vertical sub line Mean Time To Repair */
$pdf->Line(785, 145, 785, 185);
/* end */
/* header vertical sub line Mean Time Between Failures */
$pdf->Line(920, 145, 920, 185);
/* end */


/* end */
/* header vertical line */
$pdf->Line(70, 110, 70, 590);
$pdf->Line(145, 110, 145, 185);
$pdf->Line(360, 110, 360, 185);
$pdf->Line(480, 110, 480, 185);
$pdf->Line(600, 110, 600, 185);
$pdf->Line(720, 110, 720, 185);
$pdf->Line(850, 110, 850, 185);
//$pdf->Line(95, 110, 95, 590);
//$pdf->Line(140, 110, 140, 590);
//$pdf->Line(210, 110, 210, 590);
/* end */
$pdf->SetXY(22,145);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Plant" ,0,1,'L');

$pdf->SetXY(15,220);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Wire Plant" ,0,1,'L');

//wire plant empty line
$pdf->Line(70, 210, 994, 210);
/* end */


/* header vertical sub line preventive maintainance */


//$pdf->Line(145, 250, 145, 210);
//$pdf->Line(360, 250, 360, 210);
//$pdf->Line(480, 250, 480, 210);
//$pdf->Line(600, 250, 600, 210);
//$pdf->Line(720, 250, 720, 210);
//$pdf->Line(850, 250, 850, 210);

//$pdf->Line(205, 250, 205, 210);
//$pdf->Line(265, 250, 265, 210);
//$pdf->Line(312, 250, 312, 210);
/* end */
/* header vertical sub line Breakdown */
//$pdf->Line(420, 250, 420, 210);
/* end */
/* header vertical sub line Breakdown Hours */
//$pdf->Line(540, 250, 540, 210);
/* end */
/* header vertical sub line Repair Time */
//$pdf->Line(660, 250, 660, 210);
/* end */
/* header vertical sub line Mean Time To Repair */
//$pdf->Line(785, 250, 785, 210);
/* end */
/* header vertical sub line Mean Time Between Failures */
//$pdf->Line(920, 250, 920, 210);

/* end */





$pdf->SetXY(75,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');    
$pdf->MultiCell(66,8, "Year : ".$years,0,'C');


$pdf->SetXY(160,124);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(0,0, "Preventive Maintainance Complains Score",0,'L');

$pdf->SetXY(390,120);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(66,10, "Breakdown" ,0,'L');

$pdf->SetXY(500,125);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(0,0, "Breakdown Hours" ,0,'L');

$pdf->SetXY(630,125);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(0,0, "Repair Time" ,0,'L');

$pdf->SetXY(755,114);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(66,12, "Mean Time To Repair" ,0,'L');

$pdf->SetXY(870,114);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->SetFillColor('0','176','240');
////$pdf->Rect(113, 130, 67, 19.5, 'F');
$pdf->MultiCell(100,12, "Mean Time Between Failures" ,0,'L');


/* month */
$pdf->SetXY(85,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->Cell(0,0, "Month" ,0,'L');
/* end */	

$pdf->SetXY(150,155);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "No Of MAchine",0,'L');

$pdf->SetXY(210,155);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Actual PM Done",0,'L');

$pdf->SetXY(270,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(320,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Rating",0,'L');

$pdf->SetXY(370,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(425,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "No of BD",0,'L');

$pdf->SetXY(490,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(550,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "BD Hrs",0,'L');

$pdf->SetXY(610,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(675,160);

$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "RT",0,'L');

$pdf->SetXY(730,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(795,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(40,10, "MTTR In Hrs",0,'L');

$pdf->SetXY(865,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(66,10, "Target",0,'L');

$pdf->SetXY(940,160);
$pdf->SetFont('','B','10');
$pdf->SetTextColor('0','0','0');
$pdf->MultiCell(40,10, "MTBF In Hrs",0,'L');
$y = $pdf->getY();
        





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
