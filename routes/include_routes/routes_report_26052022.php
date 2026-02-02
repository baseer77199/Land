<?php

 /*Pm Monthly Report*/
 Route::get('pmmonthlyreport', array('as' => '','check'=>'','menu'=>'pmmonthlyreport', 'label'=>'','uses' =>'PmreportController@pmmonthlyindex'))->name('pmmonthlyreport');
 Route::get('getpmmonthlydata','PmreportController@getpmmonthlydata')->name('getpmmonthlydata');

 

 Route::get('pmmachinereport', array('as' => '','check'=>'','menu'=>'pmmachinereport', 'label'=>'','uses' =>'PmreportController@pmmachineindex'))->name('pmmachinereport');
 Route::get('pmmachinedata','PmreportController@getpmmachinedata')->name('pmmonthlydata');

  Route::get('pmhistoryreport', array('as' => '','check'=>'','menu'=>'pmhistoryreport', 'label'=>'','uses' =>'PmreportController@pmhistoryindex'))->name('pmhistoryreport');
 //Route::get('getpmmachinedata','PmreportController@getpmmachinedata')->name('getpmmonthlydata');
 Route::get('gethistoryreport','PmreportController@gethistoryreport')->name('gethistoryreport');

 /*Pm Yearly Report*/
 Route::get('pmsixschedule', array('as' => '','check'=>'','menu'=>'pmsixschedule', 'label'=>'','uses' =>'PmreportController@pmyearlyindex'))->name('pmyearlyschedule');
 Route::get('getpmyearlydata','PmreportController@getpmyearlydata')->name('getpmyearlydata');

 /*Pm Daily Report*/
 Route::get('dailycheckreport', array('as' => '','check'=>'','menu'=>'dailycheckreport', 'label'=>'','uses' =>'PmreportController@pmdailyindex'))->name('dailycheckreport');
 Route::get('getpmdailydata','PmreportController@getpmdailydata')->name('getpmdailydata');
 
  /*BD Analysis Time Vs Percentage - Group Wise*/
 Route::get('groupwisebdanalysisreport', array('as' => '','check'=>'','menu'=>'groupwisebdanalysisreport', 'label'=>'','uses' =>'BreakdownController@groupwiseindex'))->name('groupwisebdanalysisreport');
 Route::get('getgroupwisebdanalysisdata','BreakdownController@getgroupwisebdanalysisdata')->name('getgroupwisebdanalysisdata');

/*BD Analysis Time Vs Percentage - Machine Wise*/
 Route::get('machinewisebdanalysisreport', array('as' => '','check'=>'','menu'=>'machinewisebdanalysisreport', 'label'=>'','uses' =>'BreakdownController@machinewiseindex'))->name('machinewisebdanalysisreport');
 Route::get('getmachinewisebdanalysisdata','BreakdownController@getmachinewisebdanalysisdata')->name('getmachinewisebdanalysisdata');

/*BREAKDOWN REPORT REGISTER*/
 Route::get('bddetailreport', array('as' => '','check'=>'','menu'=>'bddetailreport', 'label'=>'','uses' =>'BreakdownController@bddetailsindex'))->name('bddetailreport');
 Route::get('getbddetailsdata','BreakdownController@getbddetailsdata')->name('getbddetailsdata');
 
 
/*CATEGORYWISE BREAKDOWN REPORT*/
 Route::get('categorywisebdreport', array('as' => '','check'=>'','menu'=>'categorywisebdreport', 'label'=>'','uses' =>'BreakdownController@categorywisebdindex'))->name('categorywisebdreport');
 Route::get('getcategorywisebddata','BreakdownController@getcategorywisebddata')->name('getcategorywisebddata');
 
 /*Group Wise CNC Machines*/
 Route::get('machinegroupwisebdreport', array('as' => '','check'=>'','menu'=>'machinegroupwisebdreport', 'label'=>'','uses' =>'BreakdownController@machinegroupwiseindex'))->name('machinegroupwisebdreport');
 Route::get('getmachinegroupwisebddata','BreakdownController@getmachinegroupwisebddata')->name('getmachinegroupwisebddata');
 
  /*Top5 BDs Category Wise*/
 Route::get('topbdcategorywisereport', array('as' => '','check'=>'','menu'=>'topbdcategorywisereport', 'label'=>'','uses' =>'BreakdownController@topbdcategorywiseindex'))->name('topbdcategorywisereport');
 Route::get('gettopbdcategorywisebddata','BreakdownController@gettopbdcategorywisebddata')->name('gettopbdcategorywisebddata');
 
  /*Top5 BDs MACHINE Wise*/
 Route::get('topbdmachinewisereport', array('as' => '','check'=>'','menu'=>'topbdmachinewisereport', 'label'=>'','uses' =>'BreakdownController@topbdmachinewiseindex'))->name('topbdmachinewisereport');
 Route::get('gettopbdmachinewisebddata','BreakdownController@gettopbdmachinewisebddata')->name('gettopbdmachinewisebddata');
 
   /*Top5 BDs Type Wise*/
 Route::get('topbdtypewisereport', array('as' => '','check'=>'','menu'=>'topbdtypewisereport', 'label'=>'','uses' =>'BreakdownController@topbdtypewiseindex'))->name('topbdtypewisereport');
 Route::get('gettopbdtypewisebddata','BreakdownController@gettopbdtypewisebddata')->name('gettopbdtypewisebddata');
 
 //Spare report
Route::get('sparerpt', array('as' => '','check'=>'','menu'=>'Used Spare Report', 'label'=>'','uses' => 'SparereportController@index'))->name('sparerpt');
Route::get('getsparerptData', 'SparereportController@getsparerptData')->name('getsparerptData');
Route::get('qohreport', array('as' => '','check'=>'','menu'=>'Used Spare Report', 'label'=>'','uses' => 'SparereportController@qohreport'))->name('qohrepot');
Route::get('getqohreportData', 'SparereportController@getqohreportData')->name('getqohreportData');

//Datewise Report
Route::get('datewiserpt', array('as' => '','check'=>'','menu'=>'Breakdown Report', 'label'=>'','uses' => 'DatewiserptController@index'))->name('datewiserpt');
Route::get('getdatewiserpt', 'DatewiserptController@getdatewiserpt')->name('getdatewiserpt');


//Machine Yearly Report
 Route::get('machineyearlyrpt', array('as' => '','check'=>'','menu'=>'Individual Machine Report', 'label'=>'','uses' =>'DatewiserptController@machineyearlyindex'))->name('machineyearlyrpt');
 Route::get('getmachineyearlydata','DatewiserptController@getmachineyearlydata')->name('getmachineyearlydata');

 Route::get('consolidationsheet', array('as' => '','check'=>'','menu'=>'pmyearlyschedule', 'label'=>'','uses' =>'ConsolidationsheetController@index'))->name('consolidationsheet');
 Route::get('breakdownreportsearch','ConsolidationsheetController@breakdownreportsearch')->name('breakdownreportsearch');
 
 //monthly report of breakdown machine
 Route::get('monthlybreakdownreport','ReportController@monthlybreakdownreportindex')->name('monthlybreakdownreport');
 Route::get('monthlybreakdownreportsearch/{sd}/{ed}','ReportController@monthlybreakdownreportsearch')->name('monthlybreakdownreportsearch');
 
  //monthly report of breakdown group
 Route::get('monthlybreakdownreportgroup','ReportController@monthlybreakdownreportgroupindex')->name('monthlybreakdownreport');
 Route::get('monthlybreakdownreportsearchgroup/{sd}/{ed}','ReportController@monthlybreakdownreportgroupsearch')->name('monthlybreakdownreportsearch');
 
 //breakdown register 
 Route::get('breakdownregister','ReportController@breakdownregisterindex')->name('breakdownregister');
 Route::get('breakdownregistersearch/{sd}/{ed}','ReportController@breakdownregistersearch')->name('breakdownregistersearch');
 
  //breakdown summary 
 Route::get('breakdownsummary','ReportController@breakdownsummaryindex')->name('breakdownsummary');
 Route::get('breakdownsummarysearch/{sd}/{ed}','ReportController@breakdownsummarysearch')->name('breakdownsummarysearch');
 
 //category Wise report 
 Route::get('categorywisereport','ReportController@categorywisereportindex')->name('breakdownsummary');
 Route::get('categorywisereportsearch/{sd}/{ed}/{id}','ReportController@categorywisereportsearch')->name('breakdownsummarysearch');
 
  //GROUP Wise report 
 Route::get('groupwisereport','ReportController@groupwisereportindex')->name('groupwisereport');
 Route::get('groupwisereportsearch/{sd}/{ed}/{id}','ReportController@groupwisereportsearch')->name('groupwisereportsearch');
 
   //GROUP Wise report 
 Route::get('rptbdown','ReportController@rptbdown')->name('rptbdown');
 Route::get('rptbdatareport','ReportController@rptbdatareport')->name('rptbdatareport');
 
 
   //history card
 Route::get('historycard','ReportController@historycardindex')->name('historycard');
 Route::get('historycardsearch/{sd}/{ed}/{id}','ReportController@historycardsearch')->name('historycardsearch');
 
   //top category Wise report 
 Route::get('topcategorywisereport','ReportController@topcategorywisereportindex')->name('groupwisereport');
 Route::get('topcategorywisereportsearch/{sd}/{ed}','ReportController@topcategorywisereportsearch')->name('groupwisereportsearch');
 
 
  //top MACHINE Wise report 
 Route::get('topmachinewisereport','ReportController@topmachinewisereportindex')->name('groupwisereport');
 Route::get('topmachinewisereportsearch/{sd}/{ed}','ReportController@topmachinewisereportsearch')->name('groupwisereportsearch');
 
 
 
 //top type Wise report 
 Route::get('toptypewisereport','ReportController@toptypewisereportindex')->name('groupwisereport');
 Route::get('toptypewisereportsearch/{sd}/{ed}','ReportController@toptypewisereportsearch')->name('groupwisereportsearch');
 //consolidationsheet report
  Route::get('consolidationsheetreport/{dep}/{year}/{tab}', array('as' => '','check'=>'','menu'=>'pmmonthlyreport', 'label'=>'','uses' =>'ConsolidationsheetController@getReporttab'))->name('consolidationsheetreport');
Route::get('reportdetails', array('as' => '','check'=>'','menu'=>'pmmonthlyreport', 'label'=>'','uses' =>'ConsolidationsheetController@reportindex'))->name('reportdetails');

   //history card
 Route::get('maintenance','MaintenanceReportController@index')->name('groupwisereport');
 Route::get('maintenance/{sd}/{ed}/{id}','MaintenanceReportController@searchReport')->name('groupwisereport');

 //overall machine report
Route::get('overallmachinereport', array('as' => '','check'=>'','menu'=>'Overall Machine Report', 'label'=>'','uses' =>'DatewiserptController@overallmachinereportindex'))->name('overallmachinereport');
 Route::get('getoverallmachinereport','DatewiserptController@getoverallmachinereport')->name('getoverallmachinereport');
 
 //month wise machine report
Route::get('monthwisemachinereport', array('as' => '','check'=>'','menu'=>'Month Wise Machine Report', 'label'=>'','uses' =>'DatewiserptController@monthwisemachinereportindex'))->name('monthwisemachinereport');
 Route::get('getmonthwisemachinereport','DatewiserptController@getmonthwisemachinereport')->name('getmonthwisemachinereport');
 

?>