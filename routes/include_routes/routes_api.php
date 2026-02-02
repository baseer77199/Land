<?php
Route::post('api-login','APIController@mobileLogin');
Route::post('api-all-ticket','APIController@allticket');
Route::post('api-getalldata','APIController@getalldata');
Route::post('api-assignengineerticketlist','APIController@assignengineerticketlist');
Route::post('api-assigntechticketlist','APIController@assigntechticketlist');
Route::post('api-approvalrequestlist','APIController@approvalrequestlist');
Route::post('api-approvallist','APIController@approvallist');
Route::post('api-generateticket','APIController@generateticket');
Route::post('api-getassigndetails','APIController@getassigndetails');
Route::post('api-requestticket','APIController@requestticket');
Route::post('api-closeticket','APIController@closeticket');
Route::post('api-getcloselist','APIController@getcloselist');
Route::post('newticketrisse','APIController@newticketrisse');

?>