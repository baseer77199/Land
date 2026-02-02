
<?php


@include('api.php');

Route::get('/', function () {
    return view('home'); 
});
Route::get('permissioindenied', function () {    return view('error.403'); });

//Route::get('/', function () {    return view('login'); });
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();

Route::get('decvalue','Controller@decvalue');
Route::get('categoryval','HomeController@categoryval');


@include('include_routes/routes_admin.php');
@include('include_routes/routes_api.php');
@include('include_routes/flutter_api.php');
@include('include_routes/routes_report.php');

@include('include_routes/routes_machine.php');
@include('include_routes/routes_master.php');
@include('include_routes/routes_ajith.php');
@include('include_routes/routes_harish.php');
@include('include_routes/routes_sab.php');
@include('include_routes/routes_venkat.php');
@include('include_routes/routes_pm.php');
@include('include_routes/routes_spares.php');
@include('include_routes/routes_vino.php');


Route::get('/soquote/{product_id}', 'SoquoteController@uomcode');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('getnoty', 'Controller@getnoty');


/*
//Freight Terms
Route::get('freightterms', 'FreighttermsController@index')->name('freightterms');
Route::get('freighttermscreate', 'FreighttermsController@create')->name('freighttermscreate');
Route::get('freighttermsedit/{id}', 'FreighttermsController@create');
Route::get('freighttermsview/{id}', 'FreighttermsController@show');
Route::get('freighttermsdelete/{id}', 'FreighttermsController@delete')->name('freighttermsdelete');
Route::post('freighttermssave', 'FreighttermsController@save')->name('freighttermssave');
Route::get('getfreightGridData', 'FreighttermsController@getfreightGridData');*/

Route::get('productdetails/{pid}/{plid}/{ssid}/{type}', 'Controller@productDetails');



//Supplier Search
Route::get('hrmssaveinsert', 'Controller@hrmssaveinsert');
Route::get('getSuppliergridData', 'Controller@getSuppliergridData');

//customer Search
Route::get('getCustomergridData', 'Controller@getCustomergridData');
//product search
Route::get('getProductgridData', 'Controller@getProductgridData');
Route::get('getProductgridDatasubinventory', 'Controller@getProductgridDatasubinventory');
Route::get('jcomboformlogin', 'Controller@jcomboformlogin');
Route::get('jcombocomp', 'Controller@jcombocomp');
Route::get('jcomboformcomp', 'Controller@jcomboformcomp');
Route::get('jcomboformallcheck', 'Controller@jcomboformallcheck');
Route::get('jcomboformrerule', 'Controller@jcomboformrerule');
Route::get('jcustomselectcomp', 'Controller@jcustomselectcomp');
Route::get('jcustomselectactive', 'Controller@jcustomselectactive');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('jcomboform1',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' => 'Controller@jcomboform1'));

Route::get('calendarjsondatadash',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'HomeController@jsondatadash'))->name('calendarjsondatadash');

Route::get('calendarjsondatadash1',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'HomeController@calendarjsondatadash1'))->name('calendarjsondatadash1');

Route::get('/productgroupid/', 'Controller@productgroupid')->name('home');
Route::get('jcomboformtax',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'Controller@jcomboformtax'));

//notification
Route::get('Productstock', 'NotificationController@Productstock');
Route::get('jcomboformcompwithref', 'Controller@jcomboformcompwithref');
Route::get('jcomboform',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'Controller@jcomboform'));

Route::get('materialreturn',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'materialreturnController@index'));
Route::get('getmaterialreturnData',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'materialreturnController@getmaterialreturnData'))->name('getmaterialreturnData');
Route::get('materialreqcreate/{id}',array('as' => '','check'=>'','menu'=>'materialreqcreate','label'=>'','uses' => 'materialreturnController@create'))->name('materialreqcreate');	
Route::post('materialreturnsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'materialreturnController@save'))->name('jobcardsave');





?>
