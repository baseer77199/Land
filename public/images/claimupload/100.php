<?php

//PO Report
Route::get('poreport','PoreportController@index');

//Payment Details report
Route::get('paymentdetails', 'PaymentdetailsController@reportindex')->name('paymentdetails');
Route::get('getpaymentdetailsData', 'PaymentdetailsController@getpaymentdetailsData');
Route::get('getpaymentdetailsreportData', 'PaymentdetailsController@getpaymentdetailsreportData');
Route::get('payablereport/{id}', 'PaymentdetailsController@getpayablesreport')->name('payablereport');
Route::get('paymentsdownload', array('as' => '','check'=>'','menu'=>'paymentsdownload', 'uses' =>'PaymentdetailsController@index'))->name('paymentsdownload');
Route::get('paymentsamedownloaddata', array('as' => '','check'=>'','menu'=>'paymentsdownload', 'uses' =>'PaymentdetailsController@paymentsamedownloaddata'));
Route::get('paymentotherdownloaddata', array('as' => '','check'=>'','menu'=>'paymentsdownload', 'uses' =>'PaymentdetailsController@paymentotherdownloaddata'));
//Fg Min Stock Report
Route::get('fgminstockrpt', 'FgminstockrptController@index');
Route::get('getfgminstockrpt', 'FgminstockrptController@getfgminstockrpt');

//Delivery Perfomance Report
Route::get('deliveryperformancerpt', 'deliveryperformancerptController@index');
Route::get('getdeliverprfmrpt', 'deliveryperformancerptController@getdeliverprfmrpt');

//Dispatch Report
Route::get('dispatchrpt', 'dispatchrptController@index');
Route::get('getdispatchrpt', 'dispatchrptController@getdispatchrpt');

//FG Stock Ledger Report
Route::get('fgstockledgerrpt', 'FgstockledgerrptController@index');
Route::get('getstkledgerrpt', 'FgstockledgerrptController@getstkledgerrpt');

//Formulation Costing Report
Route::get('formulationcostrpt', 'formulationcostrptController@index');
Route::get('getformulationcost', 'formulationcostrptController@getformulationcost');

//Loss Analysis Report
Route::get('lossananalysisrpt', 'lossanalysisrptController@index');
Route::get('getlossanalysis', 'lossanalysisrptController@getlossanalysis');

//Loss Report
Route::get('lossrpt', 'lossrptController@index');
Route::get('getlossrpt', 'lossrptController@getlossrpt');

//WIP Period Wise Report
Route::get('wipperiodwiserpt', 'WipperiodwiserptController@index');
Route::get('getwipperiodwise', 'WipperiodwiserptController@getwipperiodwise');

//Sales Invoice Details Report
Route::get('salesinvoicedetailsrpt', 'SalesinvoicedetailsrptController@index');
Route::get('getsalesinvoicerpt', 'SalesinvoicedetailsrptController@getsalesinvoicerpt');

//RM Stock for Sales Report
Route::get('rmstockforsalesrpt', 'RmstockforsalesrptController@index');
Route::get('getrmstockforsales', 'RmstockforsalesrptController@getrmstockforsales');

//Sales Summary Report
Route::get('salessummaryrpt', 'SalessummaryrptController@index');
Route::get('getsalessummaryrpt', 'SalessummaryrptController@getsalessummaryrpt');


//Pending Purchase Invoice report
Route::get('pendingpurchasepayment', 'PendingpurchasepaymentController@index');
Route::get('getpendingpaymentData', 'PendingpurchasepaymentController@getpendingpaymentData');

//Receipt Details report
Route::get('receiptdetails', 'ReceiptdetailsController@index')->name('receiptdetails');
Route::get('getReceiptrptData', 'ReceiptdetailsController@getReceiptdetailssData');
Route::get('receivablesreport/{id}', 'ReceiptdetailsController@getreceivablesreport')->name('receivablesreport');

//Pending Invoice Details report
Route::get('pendingsalesreceipt', 'PendingsalesreceiptController@index');
Route::get('getpendingreceiptData', 'PendingsalesreceiptController@getpendingreceiptData');

//Vendor Balances report
Route::get('vendorbalancesrpt', 'VendorbalancesrptController@index');
Route::get('getvendorbalanceData', 'VendorbalancesrptController@getvendorbalanceData');

//Po Aging Summary report
Route::get('poinvoiceagingsummaryrpt', 'PoagingsummaryrptController@index');
Route::get('getpoagingsummaryData', 'PoagingsummaryrptController@getpoagingsummaryData');

//Purchase Order details report
Route::get('podetailsrpt', 'PodetailsrptController@index');
Route::get('getpodetailsData', 'PodetailsrptController@getpodetailsData');
Route::get('PodetailsreportData', 'PodetailsrptController@PodetailsreportData');

//Purchase by Vendor report
Route::get('pobyvendorrpt', 'PobyvendorrptController@index');
Route::get('getpobyvendorData', 'PobyvendorrptController@getpobyvendorData');

//Customer Balances report
Route::get('customerbalancesrpt', 'CustomerbalancesController@index');
Route::get('getcustomerbalanceData', 'CustomerbalancesController@getcustomerbalanceData');

//Sales order Details report
    Route::get('salesorderdetailsrpt', 'SalesorderdetailsrptController@index');
Route::get('getsodetailsData', 'SalesorderdetailsrptController@getsodetailsData');
Route::get('SodetailsreportData', 'SalesorderdetailsrptController@SodetailsreportData');
//So Aging Summary report
Route::get('soinvoiceagingsummaryrpt', 'SoagingsummaryrptController@index');
Route::get('getsoagingsummaryData', 'SoagingsummaryrptController@getsoagingsummaryData');

//So Aging Summary report
Route::get('deliverychallandetailsrpt', 'DcdetailsrptController@index');
Route::get('getdcdetailsData', 'DcdetailsrptController@getdcdetailsData');

Route::get('trialbalancesrpt','TrialbalancesrptController@trialbalance');
Route::get('accounttrx','TrialbalancesrptController@accounttransaction')->getName('accounttrx');
Route::get('getaccounttransaction','TrialbalancesrptController@getaccounttransaction')->getName('getaccounttransaction');
Route::get('gettrialbalance','TrialbalancesrptController@gettrialbalance')->getName('gettrialbalance');
Route::get('getgeneralledger','TrialbalancesrptController@getgeneralledger')->getName('getgeneralledger');


Route::get('generalledger','TrialbalancesrptController@generalledger')->getName('generalledger');
Route::get('journalreport', 'JournalentryController@journalreport');

Route::get('sobycustomerrpt', 'PobyvendorrptController@index1')->getName('sobyvendorrpt');


//Ledger  Report
Route::get('ledgerreport', 'JournalentryController@ledgerreport');
Route::get('journalledgerreport', 'JournalentryController@journalledgerreport');

//journal Report
Route::get('journalrpt', 'JournalentryController@journalrpt');
Route::get('journalreport', 'JournalentryController@journalreport');

Route::get('balancesheetrpt','BalancesheetrptController@balancesheet')->getName('balancesheetrpt');
Route::get('jobcardreport','JobcardController@report');
Route::get('jobcardresult/{id}','BalancesheetrptController@jobcardresult');

//purchase transcation report  
Route::get('purchasetransaction', 'PurchasetranscationController@index');
Route::get('pruchasetransreport', 'PurchasetranscationController@report');

//purchase Tax Report  
Route::get('purchasetaxaccountrpt', 'PurchasetaxaccountrptController@index')->name('purchasetaxaccountrpt');
Route::get('taxaccountrpt', 'PurchasetaxaccountrptController@potaxaccount');

//Sales Tax Report  
Route::get('salestaxaccountrpt', 'SalestaxaccountrptController@index')->name('salestaxaccountrpt');
Route::get('salestaxaccount', 'SalestaxaccountrptController@salestaxaccount');


//sales over all report
Route::get('salesreport', 'SoorderController@salesreport')->name('salesreport');
Route::get('salesreportsearch/{id}', 'SoorderController@salesreportsearch')->name('salesreportsearch');

//Purchase report
Route::get('purchasereport/{id}', 'PurchasereportController@index')->name('purchasereport');
Route::get('dispatch_view/{id}', 'DispatchController@show')->name('dispatch_view');
Route::get('soinvoice_view/{id}', 'SalesinvoiceController@show')->name('soinvoice_view');
Route::get('so_view/{id}', 'SoorderController@show')->name('so_view');

//purchase pending order qty report
Route::get('popendingqtyrpt', 'PurchasereportController@pendingindex')->name('popendingqtyrpt');
Route::get('getpopendingqty', 'PurchasereportController@getpopendingqty')->name('getpopendingqty');
//so pending qty report
Route::get('sopendingqtyrpt', 'SalesreportController@pendingsoindex')->name('sopendingqtyrpt');
Route::get('getsopendingqty', 'SalesreportController@getsopendingqty')->name('getsopendingqty');
//salesorder report
Route::get('salesorderrpt/{id}', 'SalesreportController@Salesorderdetailsreport')->name('salesorderrpt');
//purchase appoved data
Route::get('purchaseapprovedreport', 'PurchasereportController@purchaseapprovedreport')->name('purchaseapprovedreport');
Route::get('soorderapprovegriddatareport', 'PurchasereportController@soorderapprovegriddata')->name('soorderapprovegriddata');
//product stock report
Route::get('productstkledgerrpt', 'SalesinvoicedetailsrptController@index')->name('productstkledgerrpt');
Route::get('productstkledgerdata', 'SalesinvoicedetailsrptController@getproductstkledgerdata')->name('productstkledgerdata');
//suppilerrating
 
 Route::get('qtysupply', 'SupplierratingsController@supplierratings')->name('qtysupply');

 

?>
