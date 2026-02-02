<?php


Route::post('api-flutter-login','AndroidController@mobileLogin');
Route::post('api-flutter-all-ticket','AndroidController@allticket');
Route::post('api-flutter-getalldata','AndroidController@getalldata');
Route::post('api-flutter-assignengineerticketlist','AndroidController@assignengineerticketlist');
Route::post('api-flutter-assigntechticketlist','AndroidController@assigntechticketlist');
Route::post('api-flutter-approvalrequestlist','AndroidController@approvalrequestlist');
Route::post('api-flutter-approvallist','AndroidController@approvallist');

Route::post('api-flutter-generateticket',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'AndroidController@generateticket','middleware' => 'throttle:4,1'));

Route::post('api-flutter-getassigndetails','AndroidController@getassigndetails');
Route::post('api-flutter-requestticket','AndroidController@requestticket');
Route::post('api-flutter-closeticket','AndroidController@closeticket');
Route::post('api-flutter-getcloselist','AndroidController@getcloselist');
Route::post('api-flutter-newticketrisse','AndroidController@newticketrisse');
Route::post('api-flutter-notification','AndroidController@notificationlist');
Route::post('api-flutter-getticket','AndroidController@getTicketID');
Route::post('api-flutter-changepassword','AndroidController@changepassword');
Route::post('api-flutter-sendMessage','AndroidController@sendMessage');

Route::get('api-flutter-getusertoken','AndroidController@gettoken');

?>