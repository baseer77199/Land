<?php

Route::get('configform', array('as' => '','check'=>'','menu'=>'configform','label'=>'', 'uses' =>'ConfigController@index1'))->name('configform');
Route::get('gettablefield/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'', 'uses' =>'ConfigController@gettablefield'))->name('gettablefield');
Route::post('configurationdatasave', array('as' => '','check'=>'','menu'=>'','label'=>'', 'uses' =>'ConfigController@configurationdatasave'))->name('configurationdatasave');

Route::get('uploadconfig', array('as' => '','check'=>'','menu'=>'uploadconfig','label'=>'', 'uses' =>'ConfigController@uploadindex'))->name('uploadconfig');
Route::get('downloadtemplate/{module}', array('as' => '','check'=>'','menu'=>'','label'=>'', 'uses' =>'ConfigController@getDownloadtemplate'))->name('downloadtemplate');
Route::post('uploadconfigsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ConfigController@uploadsave'));

//Template Uploads
Route::get('agencyupload', array('as' => '','check'=>'','menu'=>'agency','label'=>'', 'uses' =>'ConfigController@uploadindex'))->name('agencyupload');
Route::get('vendorupload', array('as' => '','check'=>'','menu'=>'vendor','label'=>'', 'uses' =>'ConfigController@uploadindex'))->name('vendorupload');
Route::get('sparesupload', array('as' => '','check'=>'','menu'=>'sparescreation','label'=>'', 'uses' =>'ConfigController@uploadindex'))->name('sparesupload');
Route::get('departmentupload', array('as' => '','check'=>'','menu'=>'department','label'=>'', 'uses' =>'ConfigController@uploadindex'))->name('departmentupload');
Route::get('breakdowntypeupload', array('as' => '','check'=>'','menu'=>'breakdowntype','label'=>'', 'uses' =>'ConfigController@uploadindex'))->name('breakdowntypeupload');
Route::get('designationupload', array('as' => '','check'=>'','menu'=>'designation','label'=>'', 'uses' =>'ConfigController@uploadindex'))->name('designationupload');
Route::get('userupload', array('as' => '','check'=>'','menu'=>'user','label'=>'', 'uses' =>'ConfigController@uploadindex'))->name('userupload');
Route::get('machinegroupupload', array('as' => '','check'=>'','menu'=>'machinegroup','label'=>'', 'uses' =>'ConfigController@uploadindex'))->name('machinegroupupload');


Route::get('attendanceupload',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'attendenceuploadController@index'));
Route::post('attendenceuploadsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'attendenceuploadController@save'));
Route::get('getattenddenceuploadgriddata', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'attendenceuploadController@getgriddata'))->name('getattenddenceuploadgriddata');


Route::get('floatingpointsettings',array('as' => '','check'=>'','menu'=>'floatingpointsettings','label'=>'','uses' =>'FloatingpointsettingsController@index'));
Route::post('fpointsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'FloatingpointsettingsController@save'));

Route::get('dateformate',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'Controller@dateform'))->name('dateformate');
Route::get('dateformatssettings',array('as' => '','check'=>'','menu'=>'dateformatssettings','label'=>'','uses' =>'DateformatsController@index'));
Route::get('dateformatssettingscreate',array('as' => '','check'=>'create','menu'=>'','label'=>'create','uses' =>'DateformatsController@create'));
Route::get('dateformatssettingsedit/{id}',array('as' => '','check'=>'edit','menu'=>'','label'=>'edit','uses' =>'DateformatsController@create'));
Route::get('dateformatssettingsdelete/{id}',array('as' => '','check'=>'delete','menu'=>'','label'=>'delete','uses' =>'DateformatsController@dateformatssettingsdelete'));
Route::post('dateformatssettingssave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'DateformatsController@save'));
Route::get('getDateformatsData',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'DateformatsController@getDateformatsData'));
Route::get('dateformatcheck',array('as' => '','check'=>'','menu'=>'','label'=>'','uases' =>'DateformatsController@dateformatcheck'));


Route::get('timeformats',array('as' => '','check'=>'','menu'=>'timeformats','label'=>'','uses' =>'TimeformatsController@index'));
Route::get('timeformatscreate',array('as' => '','check'=>'','menu'=>'','label'=>'create','uses' =>'TimeformatsController@create'));
Route::get('timeformatsedit/{id}',array('as' => '','check'=>'edit','menu'=>'','label'=>'edit','uses' =>'TimeformatsController@create'));
Route::get('timeformatcheck',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'TimeformatsController@timeformatcheck'));

Route::get('toolsmenuconfig',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'toolsmenuconfighdrController@index'))->name('toolsmenuconfig');
Route::get('toolsmenucheck',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'toolsmenuconfighdrController@toolsmenucheck'))->name('toolsmenucheck');
Route::get('getToolData',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'toolsmenuconfighdrController@getToolData'))->name('getToolData');
Route::get('toolsmenuconfighdrcreate/{id}',array('as' => '','check'=>'create','menu'=>'','label'=>'create','uses' =>'toolsmenuconfighdrController@create'))->name('toolsmenuconfighdrcreate');
Route::get('toolsmenuconfighdrview/{id}',array('as' => '','check'=>'view','menu'=>'toolsmenuconfig','label'=>'view','uses' =>'toolsmenuconfighdrController@show'))->name('toolsmenuconfighdrview');
Route::get('toolsmenuconfighdredit/{id}',array('as' => 'toolsmenuconfighdredit', 'check'=>'edit','menu'=>'toolsmenuconfig','label'=>'edit', 'uses' => 'toolsmenuconfighdrController@edit'));
Route::get('toolsmenuconfighdrdelete/{id}',array('as' => '','check'=>'delete','menu'=>'toolsmenuconfig','label'=>'delete','uses' =>'toolsmenuconfighdrController@delete'));
Route::post('toolsmenuconfighdrsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'toolsmenuconfighdrController@save'))->name('toolsmenuconfighdrsave');



Route::get('timeformatsview',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'TimeformatsController@view'));
Route::get('gettimeformatsData',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'TimeformatsController@gettimeformatsData'));
Route::get('timeformatdelete/{id}',array('as' => '','check'=>'delete','menu'=>'','label'=>'delete','uses' =>'TimeformatsController@timeformatdelete'))->name('timeformatdelete');
Route::post('timeformatsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'TimeformatsController@save'))->name('timeformatsave');
Route::post('Login/signin',array('as' => '','check'=>'','menu'=>'signin','label'=>'','uses' =>'LoginController@Signin'));

Route::get('columnpermission',array('as' => '','check'=>'','menu'=>'columnpermission','label'=>'','uses' =>'ColumnpermissionController@index'))->name('columnpermission');
Route::post('coloumnsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ColumnpermissionController@save'));
Route::get('getcolumns',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ColumnpermissionController@getcolumns'));
Route::get('menuarrangement',array('as' => '','check'=>'','menu'=>'menuarrangement','label'=>'','uses' =>'MenuarrangementController@index'));
Route::post('menuarrange',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MenuarrangementController@create'));
/* Create Group */
Route::get('group',array('as' => '','check'=>'','menu'=>'Create Group','label'=>'','uses' =>'GroupaccessController@index'));
Route::get('/groupname/checkname/', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'GroupaccessController@getCheckname'));
Route::post('/groupaccess/save/', array('as' => '','check'=>'','menu'=>'','label'=>'save','uses' =>'GroupaccessController@save'));
Route::get('/groupaccess/edit/', array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'GroupaccessController@show'));
Route::get('/groupaccess/delete/', array('as' => '','check'=>'','menu'=>'','label'=>'delete','uses' =>'GroupaccessController@remove'));
Route::get('getgroup', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'GroupaccessController@getgroupgriddata'));
/* end */
/*Create User */
Route::get('user', array('as' => '','check'=>'','menu'=>'user','label'=>'','uses' =>'CreateuserController@index'))->name('user');
Route::post('createuser', array('as' => 'createuser', 'check'=>'create','menu'=>'user','label'=>'create', 'uses' => 'CreateuserController@create'));
Route::post('usersave', array('as' => '','check'=>'','menu'=>'','label'=>'save','uses' =>'CreateuserController@save'));
Route::get('userData',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'CreateuserController@userdata'));
Route::get('useredit/{id}',array('as' => '','check'=>'Edit','menu'=>'user','label'=>'edit','uses' =>'CreateuserController@create'));
Route::get('userprofile/{id}',array('as' => '','check'=>'edit','menu'=>'userprofile','label'=>'edit','uses' =>'CreateuserController@create'));
Route::post('userviews', array('as' => '','check'=>'View','menu'=>'user','label'=>'view','uses' =>'CreateuserController@show'))->name('userview');
Route::get('userdelete/{id}', array('as' => '','check'=>'delete','menu'=>'user','label'=>'view','uses' =>'CreateuserController@delete'))->name('userview');



/* end */
/*Create Group Access */
Route::get('companyaccess', array('as' => '','check'=>'','menu'=>'Company Access','label'=>'','uses' =>'GroupmenuaccessController@indexcompany'))->name('groupname');
Route::get('createcompanyaccess', array('as' => '','check'=>'','menu'=>'Company Access','label'=>'','uses' =>'GroupmenuaccessController@createcompany'))->name('createcompany');
Route::post('companyaccesssave', array('as' => '','check'=>'','menu'=>'Company Access','label'=>'','uses' =>'GroupmenuaccessController@companyaccesssave'))->name('save');
Route::get('companyaccessedit/{id}', array('as' => '','check'=>'','menu'=>'Company Access','label'=>'','uses' =>'GroupmenuaccessController@createcompany'))->name('edit');
Route::get('groupmenuaccess', array('as' => '','check'=>'','menu'=>'Group Access','label'=>'','uses' =>'GroupmenuaccessController@index'))->name('groupname');
Route::post('groupaccessedit', array('as' => '','check'=>'','menu'=>'Group Access','label'=>'','uses' =>'GroupmenuaccessController@create'))->name('edit');
Route::get('creategroupaccess', array('as' => '','check'=>'','menu'=>'Group Access','label'=>'','uses' =>'GroupmenuaccessController@create'))->name('create');
Route::get('subheadmenu/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'GroupmenuaccessController@subheadmenu'))->name('subheadmenu');
Route::post('groupaccess', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'GroupmenuaccessController@save'))->name('save');
Route::get('companyaccess/{id}', array('as' => '','check'=>'','menu'=>'companyaccess','label'=>'','uses' =>'GroupmenuaccessController@menudata'))->name('menudata');
Route::get('buttonnameusers/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'GroupmenuaccessController@buttonnameuser'))->name('buttonname');
/* end */
/*Create User Access */
Route::get('useraccess', array('as' => '','check'=>'','menu'=>'User Access','label'=>'','uses' =>'UseraccessController@index'))->name('usertable');
Route::get('createuseraccess', array('as' => '','check'=>'','menu'=>'User Access','label'=>'','uses' =>'UseraccessController@create'))->name('create');
Route::get('groupaccess/{id}', array('as' => '','check'=>'','menu'=>'groupaccess','label'=>'','uses' =>'UseraccessController@menudata'))->name('menudata');
Route::get('subheadname/{id}/{ids}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'UseraccessController@subheaddata'))->name('subheaddata');
Route::get('buttonname/{id}', array('as' => '','check'=>'','menu'=>'buttonname','label'=>'','uses' =>'UseraccessController@buttonname'))->name('buttonname');
Route::get('buttonnameuser/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'UseraccessController@buttonnameuser'))->name('buttonname');
Route::post('useraccessedit', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'UseraccessController@create'))->name('create');
Route::post('saves', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'UseraccessController@save'));
/* end */

/*Look ups */
Route::get('lookup', array('as' => '','check'=>'','menu'=>'lookup','label'=>'','uses' =>'LookuphdrController@index'))->name('lookups');
Route::get('getlookupdata', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'LookuphdrController@lookupdata'))->name('getlookupdata');
Route::get('lookcreate', array('as' => '','check'=>'create','menu'=>'lookup','label'=>'create','uses' =>'LookuphdrController@create'))->name('create');
Route::get('lookupcreate/{id}', array('as' => '','check'=>'edit','menu'=>'lookup','label'=>'edit','uses' =>'LookuphdrController@create'))->name('create');
Route::post('lookupsave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'LookuphdrController@save'));
Route::get('lookupsaveview/{id}', array('as' => '','check'=>'view','menu'=>'lookup','label'=>'view','uses' =>'LookuphdrController@getShow'))->name('lookupsaveview');

/* end */

/* COMPANY */
Route::get('company', array('as' => '','check'=>'','menu'=>'company','label'=>'','uses' =>'CompanyController@index'))->name('company');
Route::get('getCompanyData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'CompanyController@getCompanyData'))->name('getCompanyData');
Route::post('companyform', array('as' => '','check'=>'create','menu'=>'company','label'=>'create','uses' =>'CompanyController@companyform'))->name('companyform');
Route::post('companydelete/{id}', array('as' => '','check'=>'delete','menu'=>'company','label'=>'delete','uses' =>'CompanyController@companydelete'))->name('companydelete');
Route::post('companyview', array('as' => '','check'=>'view','menu'=>'company','label'=>'view','uses' =>'CompanyController@companyview'))->name('companyview');
Route::post('companysave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'CompanyController@companysave'))->name('companysave');
Route::get('companycheckname',array('as' => '','check'=>'','menu'=>'company','label'=>'','uses' =>'CompanyController@companycheckname'))->name('companycheckname'); 
/* END */

/* LOCTAION */
Route::get('location', array('as' => '','check'=>'','menu'=>'location','label'=>'','uses' =>'LocationController@index'))->name('location');
Route::get('getlocationData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'LocationController@getlocationData'))->name('getlocationData');
Route::get('locationdelete/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'delete','uses' =>'LocationController@locationdelete'))->name('locationdelete');
Route::post('locationsave', array('as' => '','check'=>'','menu'=>'','label'=>'save','uses' =>'LocationController@locationsave'))->name('locationsave');
Route::get('loccheckname',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'LocationController@loccheckname'))->name('loccheckname'); 
/* END */

/* ORGANIZATION*/
Route::get('organization', array('as' => '','check'=>'','menu'=>'organization','label'=>'','uses' =>'OrganizationController@index'))->name('organization');
Route::get('getOrganizationData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'OrganizationController@getOrganizationData'))->name('getOrganizationData');
Route::get('organizationdelete/{id}', array('as' => '','check'=>'delete','menu'=>'','label'=>'delete','uses' =>'OrganizationController@organizationdelete'))->name('organizationdelete');
Route::get('orgcheckname',array('as' => '','check'=>'','menu'=>'','uses' =>'OrganizationController@orgcheckname'))->name('orgcheckname'); 
Route::post('organizationsave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'OrganizationController@organizationsave'))->name('organizationsave');
/* END */

/* PROJECTTYPE*/
Route::get('projecttype', array('as' => '','check'=>'','menu'=>'projecttype','label'=>'','uses' =>'ProjecttypesController@index'))->name('projecttype');
Route::get('getprojecttypeData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProjecttypesController@getprojecttypeData'))->name('getprojecttypeData');
Route::get('projecttypedelete/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProjecttypesController@projecttypedelete'))->name('projecttypedelete');
Route::post('projecttypesave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProjecttypesController@projecttypesave'))->name('projecttypesave');
Route::get('getCheckprojecttype', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProjecttypesController@getCheckprojecttype'))->name('getCheckprojecttype');
/* END */

/* PROJECT*/
Route::get('project', array('as' => '','check'=>'','menu'=>'project','label'=>'','uses' =>'ProjectController@index'))->name('ProjectController');
Route::get('getprojectData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProjectController@getprojectData'))->name('getprojectData');
Route::get('projectdelete/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProjectController@projectdelete'))->name('projectdelete');
Route::post('projectsave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProjectController@projectsave'))->name('projectsave');
Route::get('getCheckprojectname', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProjectController@getCheckname'))->name('getCheckprojectname');
/* END */

//Product Setting
Route::get('productsetting', array('as' => '','check'=>'','menu'=>'productsetting','label'=>'','uses' =>'ProductsettingController@index'))->name('productsetting');
Route::post('productsettingsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProductsettingController@productsettingsave'))->name('productsetting');
Route::get('getproductsetting',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ProductsettingController@getproductsetting'));
/* END */

/*QC Approval Setting*/
Route::get('getqcapprovaldata',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'QcapprovalsettingsController@getqcapprovaldata'))->name('getqcapprovaldata');
Route::get('qcapprovalsettings',array('as' => '','check'=>'','menu'=>'qcapprovalsettings','label'=>'','uses' =>'QcapprovalsettingsController@create'))->name('qcapprovalsettings');
Route::get('productcategorycheck/{id}',array('as' => '','check'=>'','menu'=>'productcategorycheck','label'=>'','uses' =>'QcapprovalsettingsController@check'))->name('productcategorycheck');
Route::post('qcapprovalsettingssave',array('as' => '','check'=>'','menu'=>'qcapprovalsettings','label'=>'','uses' =>'QcapprovalsettingsController@qcapprovalsettingssave'))->name('qcapprovalsave');
/*End*/
 // Notification
 Route::get('notification', array('as' => '','check'=>'','menu'=>'notification','label'=>'','uses' =>'NotificationController@index'))->name('notification');
 Route::get('module_data/{id}', array('as' => '','check'=>'','menu'=>'module_data','label'=>'','uses' =>'NotificationController@show'))->name('notification');
 Route::post('userdata', array('as' => '','check'=>'','menu'=>'userdata','label'=>'','uses' =>'NotificationController@store'))->name('notification');
 Route::get('editnotificationsetting', array('as' => '','check'=>'','menu'=>'editnotificationsetting','label'=>'','uses' =>'NotificationController@update'))->name('notification');
 Route::get('triggernotification', array('as' => '','check'=>'','menu'=>'triggernotification','label'=>'','uses' =>'TriggernotificationController@data'))->name('notification');
 
 // Task manager
Route::get('taskmanager', array('as' => '','check'=>'','menu'=>'taskmanager','label'=>'','uses' =>'TaskmanagerController@index'))->name('taskmanager');
Route::get('gettaskmanData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'TaskmanagerController@gettaskmanData'))->name('gettaskmanData');
Route::get('taskmanagercreate/{id}', array('as' => '','check'=>'create','menu'=>'taskmanager','label'=>'create','uses' =>'TaskmanagerController@create'))->name('taskmanagercreate');
Route::post('taskmanagersave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'TaskmanagerController@save'))->name('taskmanagersave');
Route::get('taskmanageredit/{id}', array('as' => '','check'=>'edit','menu'=>'taskmanager','label'=>'edit','uses' =>'TaskmanagerController@create'))->name('taskmanageredit');
Route::get('taskmanagerview/{id}', array('as' => '','check'=>'view','menu'=>'taskmanager','label'=>'view','uses' =>'TaskmanagerController@show'))->name('taskmanagerview');
Route::get('taskmanagerdelete/{id}', array('as' => '','check'=>'delete','menu'=>'taskmanager','label'=>'delete','uses' =>'TaskmanagerController@destroy'))->name('taskmanagerdelete');
Route::get('taskmanagerapproval', array('as' => '','check'=>'approve','menu'=>'taskmanagerapproval','label'=>'approve','uses' =>'TaskmanagerController@index'))->name('taskmanagerapproval');
Route::get('taskmanagerupdate', array('as' => '','check'=>'update','menu'=>'taskmanagerupdate','label'=>'update','uses' =>'TaskmanagerController@index'))->name('taskmanagerupdate');

Route::get('reportelements',array('as' => '','check'=>'','menu'=>'reportelements','label'=>'','uses' =>'RptdisplayelementshdrController@index'))->name('reportelements');
Route::get('rptdisplayelementsdelete/{id}',array('as' => '','check'=>'delete','menu'=>'reportelements','label'=>'delete','uses' =>'RptdisplayelementshdrController@rptdisplayelementsdelete'));
Route::get('rptdisplayelementscreate/{id}',array('as' => '','check'=>'create','menu'=>'reportelements','label'=>'create','uses' =>'RptdisplayelementshdrController@create'))->name('rptdisplayelementscreate');
Route::post('rptdisplayelementsave',array('as' => '','check'=>'save','menu'=>'','label'=>'save','uses' =>'RptdisplayelementshdrController@save'))->name('rptdisplayelementsave');
Route::get('getrptdispdata',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'RptdisplayelementshdrController@getrptdispdata'))->name('getrptdispdata');
Route::get('rptdisplayelementsview/{id}',array('as' => '','check'=>'view','menu'=>'reportelements','label'=>'view','uses' =>'RptdisplayelementshdrController@view'))->name('rptdisplayelementsview');
//Route::get('displayelementcheckname','RptdisplayelementshdrController@getDisplayelementcheckname')->name('displayelementcheckname');

Route::get('approvalsettings',array('as' => '','check'=>'','menu'=>'approvalsettings','label'=>'','uses' =>'ApprovalsettingsController@index'))->name('approvalsettings');
Route::get('approvalsettingscreate',array('as' => '','check'=>'create','menu'=>'approvalsettings','label'=>'create','uses' =>'ApprovalsettingsController@create'))->name('approvalsettingscreate');
Route::get('approvalsettingsedit/{id}',array('as' => '','check'=>'edit','menu'=>'approvalsettings','label'=>'edit','uses' =>'ApprovalsettingsController@create'))->name('approvalsettingsedit');
Route::post('approvalsettingssave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ApprovalsettingsController@save'))->name('approvalsettingssave');
Route::get('approvalsettingsview/{id}',array('as' => '','check'=>'view','menu'=>'approvalsettings','label'=>'view','uses' =>'ApprovalsettingsController@show'))->name('approvalsettingsview');
Route::get('getApprovalsettingsData',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ApprovalsettingsController@getApprovalsettingsData'))->name('getApprovalsettingsData');
Route::get('approvalsettingschk',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ApprovalsettingsController@approvalsettingschk'))->name('approvalsettingschk');

//Route::get('Approvaldatacheck','Controller@Approvaldatacheck')->name('Approvaldatacheck');

//Time Out Check
Route::get('timeoutcheck',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'ApprovalsettingsController@timeoutcheck'))->name('timeoutcheck');

Route::get('jobreportsettings',array('as' => '','check'=>'','menu'=>'jobreportsettings','label'=>'','uses' =>'JobreportsettingsController@index'));
Route::post('jobreportsave',array('as' => '','check'=>'','menu'=>'jobreportsettings','label'=>'','uses' =>'JobreportsettingsController@store'));


/* COMPANY */
Route::get('company', array('as' => '','check'=>'','menu'=>'company','label'=>'','uses' =>'CompanyController@index'))->name('company');
Route::get('getCompanyData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'CompanyController@getCompanyData'))->name('getCompanyData');
Route::get('companyform/{id}', array('as' => '','check'=>'create','menu'=>'company','label'=>'create','uses' =>'CompanyController@companyform'))->name('companyform');
Route::get('companydelete/{id}', array('as' => '','check'=>'delete','menu'=>'','label'=>'delete','uses' =>'CompanyController@companydelete'))->name('companydelete');
Route::get('companyview/{id}', array('as' => '','check'=>'view','menu'=>'company','label'=>'view','uses' =>'CompanyController@companyview'))->name('companyview');
Route::post('companysave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'CompanyController@companysave'))->name('companysave');
Route::get('companycheckname',array('as' => '','check'=>'','menu'=>'company','label'=>'','uses' =>'CompanyController@companycheckname'))->name('companycheckname'); 
/* END */
Route::get('department', array('as' => '','check'=>'','menu'=>'department','label'=>'','uses' =>'DepartmentController@index'))->name('department');
Route::post('department/save', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'DepartmentController@save'))->name('departmentsave');
Route::get('departmentgrid', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'DepartmentController@departmentgriddata'))->name('departmentgrid');
Route::get('departmentdelete/{id}', 'DepartmentController@destroy');
Route::get('departmentnamechk', array('as' => '','check'=>'','menu'=>'department','label'=>'','uses' =>'DepartmentController@getCheckname'))->name('departmentnamechk');

Route::get('machinegroup', array('as' => '','check'=>'','menu'=>'machinegroup','label'=>'','uses' =>'MachinegroupController@index'))->name('machinegroup');
Route::post('machinegroup/save', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinegroupController@save'))->name('machinegroupsave');
Route::get('machinegroupgrid', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinegroupController@machinegroupgriddata'))->name('machinegroupgrid');
Route::get('machinegroupdelete/{id}', 'MachinegroupController@destroy');
Route::get('machinegroupnamechk', array('as' => '','check'=>'','menu'=>'machinegroup','label'=>'','uses' =>'MachinegroupController@getCheckname'))->name('machinegroupnamechk');



Route::get('organization','OrganizationController@index')->name('organization');
Route::post('organization/save', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'OrganizationController@save'))->name('organizationsave');
Route::get('organizationgrid', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'OrganizationController@organizationgriddata'))->name('organizationgrid');
Route::get('/organizationdelete/', 'OrganizationController@destroy');

Route::get('agency',array('as' => '','check'=>'create','menu'=>'agency','label'=>'','uses' =>'AgencyController@index'))->name('agency');
 Route::post('agencycreate',array('as' => '','check'=>'create','menu'=>'agency','label'=>'Create','uses' =>'AgencyController@create'))->name('agencycreate');
 Route::get('agencyData',array('as' => '','check'=>'','menu'=>'agency','label'=>'','uses' =>'AgencyController@getagencyData'))->name('agencyData');
Route::get('agencynamechk',array('as' => '','check'=>'','menu'=>'agency','label'=>'','uses' =>'AgencyController@agencynamechk'))->name('agencynamechk');
Route::post('agencysave',array('as' => '','check'=>'','menu'=>'agency','label'=>'','uses' =>'AgencyController@save'))->name('agencysave');
//Route::get('agencycreate/{id}',array('as' => '','check'=>'edit','menu'=>'agency','label'=>'edit','uses' =>'AgencyController@create'))->name('agencycreate');
 Route::get('agencydelete/{id}', array('as' => '','check'=>'delete','menu'=>'agency','label'=>'delete','uses' =>'AgencyController@destroy'))->name('agencydelete');
 Route::post('agencyview', array('as' => '','check'=>'view','menu'=>'agency','label'=>'view','uses' =>'AgencyController@view'))->name('agencyview');
 

//Route::get('/agencydelete/', 'AgencyController@destroy');

Route::get('filemachine',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinefilesController@index'))->name('filemachine');
 Route::post('machinefilescreate',array('as' => '','check'=>'create','menu'=>'filemachine','label'=>'Create','uses' =>'MachinefilesController@create'))->name('machinefilescreate');
 Route::get('machinefilesData',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinefilesController@getmachinefilesData'))->name('machinefilesData');
 Route::get('machinefilesnamechk',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinefilesController@machinefilesnamechk'))->name('machinefilesnamechk');
 Route::post('machinefilessave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinefilesController@save'))->name('machinefilessave');
 //Route::get('machinefilesedit/{id}',array('as' => '','check'=>'edit','menu'=>'','label'=>'Create','uses' =>'MachinefilesController@create'))->name('machinefilesedit');
  Route::get('machinefilesdelete/{id}', array('as' => '','check'=>'delete','menu'=>'filemachine','label'=>'delete','uses' =>'MachinefilesController@destroy'))->name('machinefilesdelete');
//Route::get('/machinefilesdelete/', 'MachinefilesController@destroy');
//Route::get('machinefilescreate/{id}',array('as' => '','check'=>'edit','menu'=>'filemachine','label'=>'edit','uses' =>'MachinefilesController@create'))->name('machinefilescreate');
//Breakdownseverity
Route::get('breakdownseverity',array('as' => '','check'=>'','menu'=>'breakdownseverity','label'=>'','uses' =>'BreakdownseverityController@index'))->name('breakdownseverity');
Route::post('severitysave',array('as' => '','check'=>'','menu'=>'','label'=>'save','uses' =>'BreakdownseverityController@save'))->name('severitysave');
Route::get('severitygrid',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'BreakdownseverityController@severitygrids'))->name('breakdownseverity');
Route::get('severitydelete/{id}',array('as' => '','check'=>'','menu'=>'','label'=>'delete','uses' =>'BreakdownseverityController@destroy'))->name('breakdownseverity');

//DrawingFiles

Route::get('drawingfiles',array('as' => '','check'=>'','menu'=>'drawingfiles','label'=>'','uses' =>'DrawingController@index'))->name('drawingfiles');
Route::post('drawingsave',array('as' => '','check'=>'','menu'=>'','label'=>'save','uses' =>'DrawingController@store'))->name('drawingfiles');
Route::get('filegrid',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'DrawingController@filegrids'))->name('filegrid');
Route::get('drawingdelete',array('as' => '','check'=>'','menu'=>'','label'=>'delete','uses' =>'DrawingController@destroy'))->name('drawingfiles');


Route::get('frequency', array('as' => '','check'=>'','menu'=>'frequency','label'=>'','uses' =>'FrequencyController@index'))->name('frequency');
Route::post('frequencysave/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'FrequencyController@save'))->name('frequencysave/{id}');
Route::get('frequencygrid', array('as' => '','check'=>'','menu'=>'frequency','label'=>'','uses' =>'FrequencyController@frequencygrid'))->name('frequencygrid');
Route::get('frequencydelete/{id}', array('as' => '','check'=>'delete','menu'=>'frequency','label'=>'','uses' =>'FrequencyController@destroy'))->name('frequencydelete');

Route::get('checklist', array('as' => '','check'=>'','menu'=>'checklist','label'=>'','uses' =>'CheckController@index'))->name('checklist');

Route::post('checklistsave', array('as' => '','check'=>'','menu'=>'checklist','label'=>'save','uses' =>'CheckController@save'))->name('checklistsave');
Route::get('checklistgrid', array('as' => '','check'=>'','menu'=>'checklist','label'=>'','uses' =>'CheckController@checklistgrid'))->name('checklistgrid');
Route::get('checkdelete/{id}', array('as' => '','check'=>'','menu'=>'checklist','label'=>'delete','uses' =>'CheckController@destroy'))->name('checkdelete');



Route::get('designation', array('as' => '','check'=>'','menu'=>'designation','label'=>'','uses' =>'DesignationController@index'))->name('designation');


Route::post('designationsave', array('as' => '','check'=>'','menu'=>'designation','label'=>'save','uses' =>'DesignationController@save'))->name('designationsave');
Route::get('designationgrid', array('as' => '','check'=>'','menu'=>'designation','label'=>'','uses' =>'DesignationController@designationgrid'))->name('designationgrid');
Route::get('designationdelete/{id}', array('as' => '','check'=>'','menu'=>'designation','label'=>'','uses' =>'DesignationController@destroy'))->name('designationdelete');
/*Spare Quantity*/
Route::get('sparequantity', array('as' => '','check'=>'','menu'=>'sparequantity','label'=>'','uses' =>'SparequantityController@index'))->name('sparequantity');
Route::post('sparequantitysave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'SparequantityController@save'))->name('sparequantity');
Route::get('sparegriddata', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'SparequantityController@sparegriddata'))->name('sparegriddata');
Route::get('sparedelete/{id}', 'SparequantityController@destroy');





Route::get('addmachine',array('as' => '','check'=>'','menu'=>'addmachine','label'=>'','uses' =>'AddmachineController@index'))->name('addmachine');
Route::get('createmachine',array('as' => '','check'=>'create','menu'=>'addmachine','label'=>'Create','uses' =>'AddmachineController@create'))->name('createmachine');
Route::get('getmachineData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'AddmachineController@getmachineData'))->name('getmachineData');
Route::post('machinesave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'AddmachineController@save'))->name('machinesave');
Route::get('createamc','AmcController@index')->name('createamc');
Route::get('assettransfer',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'AddmachineController@assetindex'))->name('assettransfer');
Route::get('getmachinetbl',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'AddmachineController@getmachinetbl'))->name('getmachinetbl');
Route::post('assettransfersave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'AddmachineController@assetsave'))->name('assettransfersave');


//Route::post('createamc', array('as' => '','check'=>'','menu'=>'createamc','label'=>'','uses' =>'AmcController@index'))->name('createamc');
Route::post('amc/save', array('as' => '','check'=>'','menu'=>'createamc','label'=>'','uses' =>'AmcController@save'))->name('amcsave');
Route::get('getamcGridData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'AmcController@getGridData'))->name('amc');
Route::get('amcedit/{id}', array('as' => '','check'=>'create','menu'=>'company','label'=>'create','uses' =>'AmcController@edit'))->name('companyform');
Route::get('amcdelete/{id}', array('as' => '','check'=>'delete','menu'=>'','label'=>'delete','uses' =>'AmcController@destroy'))->name('companydelete');
Route::get('amcview/{id}', array('as' => '','check'=>'view','menu'=>'company','label'=>'view','uses' =>'AmcController@view'))->name('companyview');



//INITIATE PM
Route::get('initiatepm',array('as' => '','check'=>'','menu'=>'initiatepm','label'=>'','uses' =>'InitiatepmController@index'))->name('initiatepm');
Route::get('initiatepmData',array('as' => '','check'=>'','menu'=>'initiatepm','label'=>'','uses' =>'InitiatepmController@initiatepmData'));
Route::post('initiatepmcreate',array('as' => '','check'=>'initiate','menu'=>'initiatepm','label'=>'','uses' =>'InitiatepmController@create'))->name('initiatepmcreate');
Route::post('initiatepmsave',array('as' => '','check'=>'','menu'=>'initiatepm','label'=>'','uses' =>'InitiatepmController@save'))->name('initiatepm');



//USER CLEARANCE
Route::get('pmclearance',array('as' => '','check'=>'clearance','menu'=>'pmclearance','label'=>'','uses' =>'InitiatepmController@pmclearanceindex'))->name('pmclearance');
Route::get('initiatepmreschedule',array('as' => '','check'=>'','menu'=>'initiatepmreschedule','label'=>'','uses' =>'InitiatepmController@pmclearanceindex'))->name('initiatepmreschedule');
Route::get('pmclearanceData',array('as' => '','check'=>'','menu'=>'pmclearance','label'=>'','uses' =>'InitiatepmController@pmclearanceData'));
Route::post('pmclearancecreate',array('as' => '','check'=>'','menu'=>'pmclearance','label'=>'','uses' =>'InitiatepmController@pmclearancecreate'))->name('pmclearancecreate');
Route::post('pmreschedule',array('as' => '','check'=>'reschedule','menu'=>'initiatepmreschedule','label'=>'','uses' =>'InitiatepmController@edit'))->name('pmreschedule');
//Route::get('pmviewdata/{id}',array('as' => '','check'=>'','menu'=>'pmclearance','label'=>'','uses' =>'InitiatepmController@pmviewdata'))->name('pmclearancecreate');
Route::post('pmclearancesave',array('as' => '','check'=>'','menu'=>'pmclearance','label'=>'','uses' =>'InitiatepmController@pmclearancesave'))->name('pmclearance');
Route::post('pmviewdata',array('as' => '','check'=>'view','menu'=>'initiatepmreschedule','label'=>'View','uses' =>'InitiatepmController@show'))->name('machinechecklistview');


//AGENCY ALLOCATION
Route::get('pmagencyallocation',array('as' => '','check'=>'allocateagency','menu'=>'pmagencyallocation','label'=>'','uses' =>'InitiatepmController@pmagencyallocationindex'))->name('pmagencyallocation');
Route::get('pmagencyallocationData',array('as' => '','check'=>'','menu'=>'pmagencyallocation','label'=>'','uses' =>'InitiatepmController@pmagencyallocationData'));
Route::post('pmagencyallocationcreate',array('as' => '','check'=>'','menu'=>'pmagencyallocation','label'=>'','uses' =>'InitiatepmController@pmagencyallocationcreate'))->name('pmagencyallocationcreate');
Route::post('pmagencyallocationsave',array('as' => '','check'=>'','menu'=>'pmagencyallocation','label'=>'','uses' =>'InitiatepmController@pmagencyallocationsave'))->name('pmagencyallocationsave');


//AGENCY ALLOCATION
Route::get('pmmonthlycheck',array('as' => '','check'=>'checking','menu'=>'pmmonthlycheck','label'=>'','uses' =>'InitiatepmController@pmmonthlycheckindex'))->name('pmmonthlycheck');
Route::get('pmmonthlycheckData',array('as' => '','check'=>'','menu'=>'pmmonthlycheck','label'=>'','uses' =>'InitiatepmController@pmmonthlycheckData'));
Route::post('pmmonthlycheckcreate',array('as' => '','check'=>'','menu'=>'pmmonthlycheck','label'=>'','uses' =>'InitiatepmController@pmmonthlycheckcreate'))->name('pmmonthlycheckcreate');
Route::post('pmmonthlychecksave',array('as' => '','check'=>'','menu'=>'pmmonthlycheck','label'=>'','uses' =>'InitiatepmController@pmmonthlychecksave'))->name('pmmonthlychecksave');

Route::get('pmmonthlycheckapproval',array('as' => '','check'=>'','menu'=>'pmmonthlycheckapproval','label'=>'','uses' =>'InitiatepmController@pmmonthlycheckindex'))->name('pmmonthlycheckapproval');
Route::get('pmmonthlycheckapprovalData',array('as' => '','check'=>'','menu'=>'pmmonthlycheckapproval','label'=>'','uses' =>'InitiatepmController@pmmonthlycheckapprovalData'))->name('pmmonthlycheckapprovalData');
Route::post('pmmonthlycheckapprove',array('as' => '','check'=>'','menu'=>'pmmonthlycheckapproval','label'=>'','uses' =>'InitiatepmController@pmmonthlycheckcreate'))->name('pmmonthlycheckapprove');
/*Break Down Type*/
Route::get('breakdowntype', array('as' => '','check'=>'','menu'=>'breakdowntype','label'=>'breakdown type','uses' =>'BreakdowntypeController@index'))->name('breakdowntype');


Route::get('breakdowntypechkname', array('as' => '','check'=>'','menu'=>'','label'=>'breakdown type','uses' =>'BreakdowntypeController@getCheckname'))->name('breakdowntypechkname');
 Route::post('breakdowntype/save', array('as' => '','check'=>'','menu'=>'breakdowntype','label'=>'save','uses' =>'BreakdowntypeController@save'))->name('breakdowntype');
 Route::get('getbreakdowntypegridData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'BreakdowntypeController@getGridData'))->name('getbreakdowntypegridData');
 Route::get('bkdwntypeedit/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'BreakdowntypeController@edit'))->name('bkdwntypeedit');
 Route::get('bkdwntypedelete/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'BreakdowntypeController@destroy'))->name('bkdwntypedelete');
// Route::get('amcview/{id}', array('as' => '','check'=>'view','menu'=>'company','label'=>'view','uses' =>'BreakdowntypeController@view'))->name('companyview');

/** pm checklist upload **/
 Route::get('checklistimport',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinechecklistController@checklistimport'))->name('checklistimport');
 Route::post('checklistuploadsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinechecklistController@checklistuploadsave'))->name('checklistimport');

//import downloadtemplate checklist
 Route::post('download_templetechecklist',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinechecklistController@downloadtemplate'))->name('dwonloadtemplate');
 //import downloadtemplate 
 Route::post('download_templetemachinechecklist',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinechecklistController@downloadmachinechecklisttemplate'))->name('dwonloadtemplate');
 //import downloadtemplate 
 Route::post('download_templetemachine',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinechecklistController@downloadmachinetemplate'))->name('dwonloadtemplate');
 
 /** machine checklist upload **/
Route::get('machinechecklistimport',array('as' => '','check'=>'','menu'=>'Machine Checklist Upload','label'=>'','uses' =>'MachinechecklistController@machinechecklistimport'))->name('machinechecklistupload');
Route::post('machinechecklistuploadsave',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'MachinechecklistController@machinechecklistuploadsave'))->name('machinechecklistuploadsave');
Route::post('machinechecklistuploadnewsave',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'MachinechecklistController@machinechecklistuploadnewsave'))->name('machinechecklistuploadnewsave');
Route::get('getchecklistvalidate',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'MachinechecklistController@getchecklistvalidate'))->name('getchecklistvalidate');
Route::post('getchecklistload',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'MachinechecklistController@getchecklistvalidate'))->name('getchecklistvalidate');
Route::get('getchecklistuploaddata',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'MachinechecklistController@getchecklistuploaddata'))->name('getchecklistuploaddata');
Route::get('checklistuploaddelete/{id}',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'MachinechecklistController@checklistuploaddelete'))->name('checklistuploaddelete');
Route::get('checklistuploadedit/{id}',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'MachinechecklistController@checklistuploadedit'))->name('checklistuploadedit');

 /** machine upload **/
Route::get('machineimport',array('as' => '','check'=>'','menu'=>'Machine Upload','label'=>'','uses' =>'AddmachineController@machineimport'))->name('machinechecklistupload');
Route::post('machineuploadsave',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'AddmachineController@machineuploadsave'))->name('machinechecklistuploadsave');
Route::post('machineuploadnewsave',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'AddmachineController@machinechecklistuploadnewsave'))->name('machinechecklistuploadnewsave');
Route::get('getmachinevalidate',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'AddmachineController@getmachinevalidate'))->name('getchecklistvalidate');
Route::post('getmachineload',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'AddmachineController@getmachinevalidate'))->name('getchecklistvalidate');
Route::get('getmachineuploaddata',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'AddmachineController@getmachineuploaddata'))->name('getchecklistuploaddata');
Route::get('machineuploaddelete/{id}',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'AddmachineController@checklistuploaddelete'))->name('checklistuploaddelete');
Route::get('machineuploadedit/{id}',array('as' => '','check'=>'','menu'=>'','label'=>'edit','uses' =>'AddmachineController@checklistuploadedit'))->name('checklistuploadedit');

/*Create Issue*/
Route::get('pmchecksheet',array('as' => '','check'=>'','menu'=>'pmchecksheet','label'=>'','uses' =>'MachinechecklistController@index'))->name('pmchecksheet');
Route::get('getchecklistdata', array('as' => '','check'=>'','menu'=>'pmchecksheet','label'=>'','uses' =>'MachinechecklistController@getGridData'))->name('getchecklistdata');
Route::post('machinechklistcreate',array('as' => 'create','check'=>'','menu'=>'pmchecksheet','label'=>'create','uses' =>'MachinechecklistController@create'))->name('machinechklistcreate');
//Route::get('machinechecklistedit/{id}',array('as' => '','check'=>'','menu'=>'pmchecksheet','label'=>'Edit','uses' =>'MachinechecklistController@create'))->name('machinechecklistedit');
Route::post('machinechecklistview',array('as' => '','check'=>'','menu'=>'pmchecksheet','label'=>'View','uses' =>'MachinechecklistController@show'))->name('machinechecklistview');
Route::post('machinechklistsave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'MachinechecklistController@save'));


/*Spares Create*/
Route::get('sparescreation',array('as' => '','check'=>'','menu'=>'sparescreation','label'=>'','uses' =>'SpareController@index'))->name('sparescreation');
Route::get('sparechkname', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'SpareController@getCheckname'))->name('sparechkname');
Route::post('spare/save',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'SpareController@save'))->name('spare/save');
Route::get('sparegrid',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'SpareController@sparesgrids'))->name('sparegrid');
Route::get('sparedelete/{id}',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'SpareController@destroy'))->name('sparedelete');
Route::get('spareedit/{id}', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'SpareController@edit'))->name('spareedit');

// ADD machine
Route::get('addmachine',array('as' => '','check'=>'','menu'=>'addmachine','label'=>'','uses' =>'AddmachineController@index'))->name('addmachine');
Route::post('createmachine',array('as' => '','check'=>'create','menu'=>'addmachine','label'=>'Create','uses' =>'AddmachineController@create'))->name('createmachine');
//Route::get('createmachine/{id}',array('as' => '','check'=>'edit','menu'=>'addmachine','label'=>'edit','uses' =>'AddmachineController@create'))->name('createmachine');
Route::post('createmachineview',array('as' => '','check'=>'view','menu'=>'addmachine','label'=>'view','uses' =>'AddmachineController@view'))->name('createmachineview');
Route::get('createmachinedelete/{id}',array('as' => '','check'=>'delete','menu'=>'addmachine','label'=>'Delete','uses' =>'AddmachineController@destroy'))->name('createmachinedelete');
Route::get('getmachineData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'AddmachineController@getmachineData'))->name('getmachineData');
Route::post('machinesave', array('as' => '','check'=>'','menu'=>'addmachine','label'=>'','uses' =>'AddmachineController@save'))->name('machinesave');

Route::get('createamc','AmcController@index')->name('createamc');
//Route::post('createamc', array('as' => '','check'=>'','menu'=>'createamc','label'=>'','uses' =>'AmcController@index'))->name('createamc');
Route::post('amc/save', array('as' => '','check'=>'','menu'=>'createamc','label'=>'','uses' =>'AmcController@save'))->name('amcsave');
Route::get('getamcGridData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'AmcController@getGridData'))->name('amc');
Route::get('amcedit/{id}', array('as' => '','check'=>'create','menu'=>'company','label'=>'create','uses' =>'AmcController@edit'))->name('companyform');
Route::get('amcdelete/{id}', array('as' => '','check'=>'delete','menu'=>'','label'=>'delete','uses' =>'AmcController@destroy'))->name('companydelete');
Route::get('amcview/{id}', array('as' => '','check'=>'view','menu'=>'company','label'=>'view','uses' =>'AmcController@view'))->name('companyview');


/*Machine lines*/
Route::get('machinereport',array('as' => '','check'=>'','menu'=>'machinereport','label'=>'','uses' =>'AddmachineController@index'))->name('machinereport');


// /*Create Spare */
//  Route::get('sparescreation','SparequantityController@index')->name('sparescreation');
//  Route::get('breakdowntypechkname', array('as' => '','check'=>'','menu'=>'sparescreation','label'=>'','uses' =>'SparequantityController@getCheckname'))->name('breakdowntypechkname');
//  Route::post('sparequantity/save', array('as' => '','check'=>'','menu'=>'sparescreation','label'=>'','uses' =>'SparequantityController@save'))->name('sparequantity');
//  Route::get('getsparequantitygridData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'SparequantityController@getGridData'))->name('getsparequantitygridData');
//  Route::get('sparequantityedit/{id}', array('as' => '','check'=>'create','menu'=>'sparescreation','label'=>'create','uses' =>'SparequantityController@edit'))->name('sparequantityedit');
//  Route::get('sparequantitydelete/{id}', array('as' => '','check'=>'delete','menu'=>'','label'=>'delete','uses' =>'SparequantityController@destroy'))->name('sparequantitydelete');


/* Vendor */
Route::get('vendor', array('as' => '','check'=>'create','menu'=>'vendor','label'=>'','uses' =>'VendorController@index'))->name('vendor');
Route::get('getvendorData', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'VendorController@getvendorData'))->name('getvendorData');
Route::post('createvendor', array('as' => '','check'=>'create','menu'=>'vendor','label'=>'create','uses' =>'VendorController@vendorform'))->name('createvendor');
Route::post('editvendor', array('as' => '','check'=>'create','menu'=>'vendor','label'=>'edit','uses' =>'VendorController@vendorform'))->name('editvendor');

Route::get('vendordelete/{id}', array('as' => '','check'=>'delete','menu'=>'vendor','label'=>'delete','uses' =>'VendorController@vendordelete'))->name('vendordelete');
Route::post('vendorview', array('as' => '','check'=>'view','menu'=>'vendor','label'=>'view','uses' =>'VendorController@vendorview'))->name('vendorview');
Route::post('vendorsave', array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'VendorController@vendorsave'))->name('vendorsave');
Route::get('vendorcheckname',array('as' => '','check'=>'','menu'=>'vendor','label'=>'','uses' =>'VendorController@vendorcheckname'))->name('vendorcheckname'); 
/* END */

/*Create Issue*/
Route::get('createissue',array('as' => '','check'=>'','menu'=>'createissue','label'=>'createissue','uses' =>'BreakdownmaintenanceController@index'))->name('createissue');
Route::post('issuecreate',array('as' => '','check'=>'','menu'=>'createissue','label'=>'','uses' =>'BreakdownmaintenanceController@create'))->name('createissue');
Route::get('issueData',array('as' => '','check'=>'','menu'=>'createissue','label'=>'','uses' =>'BreakdownmaintenanceController@issueData'))->name('issueData');


Route::post('issuesave',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'BreakdownmaintenanceController@save','middleware' => 'throttle:4,1'));

// Route::post('',array('as' => '','check'=>'','menu'=>'','label'=>'','uses' =>'BreakdownmaintenanceController@view1'));
Route::post('userview', array('as' => '','check'=>'view','menu'=>'createissue','label'=>'view','uses' =>'BreakdownmaintenanceController@view'))->name('userview');
Route::get('sopview/{id}', array('as' => '','check'=>'','menu'=>'sopupload','label'=>'view','uses' =>'BreakdownmaintenanceController@show'))->name('sopview');

Route::get('/home', 'BreakdownmaintenanceController@view')->name('home');

// Route::get('/','BreakdownmaintenanceController@view1');

/*Allocate Engineer*/
Route::get('allocateengineer',array('as' => '','check'=>'','menu'=>'allocateengineer','label'=>'','uses' =>'BreakdownmaintenanceController@index'))->name('allocateengineer');
Route::post('engineerallocate',array('as' => '','check'=>'','menu'=>'allocateengineer','label'=>'create','uses' =>'BreakdownmaintenanceController@create'))->name('allocateengineer');

/*Allocate Technician*/
Route::get('allocatetechnician',array('as' => '','check'=>'','menu'=>'allocatetechnician','label'=>'','uses' =>'BreakdownmaintenanceController@index'))->name('allocatetechnician');

/*Raise Request*/
Route::get('requestraise',array('as' => '','check'=>'','menu'=>'requestraise','label'=>'','uses' =>'BreakdownmaintenanceController@index'))->name('requestraise');
/*Approve Request*/
Route::get('approverequest',array('as' => '','check'=>'','menu'=>'approverequest','label'=>'','uses' =>'BreakdownmaintenanceController@index'))->name('approverequest');

/*Close Request*/
Route::get('closerequest',array('as' => '','check'=>'','menu'=>'closerequest','label'=>'','uses' =>'BreakdownmaintenanceController@index'))->name('closerequest');
Route::get('getspareqty/{id}',array('as' => '','check'=>'','menu'=>'', 'label'=>'','uses' =>'BreakdownmaintenanceController@getspareqty'))->name('getspareqty');

Route::get('sopupload',array('as' => '','check'=>'','menu'=>'SOP','label'=>'','uses' =>'BreakdownmaintenanceController@index'))->name('sopupload');

/*** Shift Timings ***/
Route::get('shifttiming',array('as' => '','check'=>'','menu'=>'shifttiming','label'=>'','uses' =>'ShiftdetailController@index'))->name('shifttiming');
Route::get('shifttiminggrid',array('as' => '','check'=>'','menu'=>'shifttiming','label'=>'','uses' =>'ShiftdetailController@ShiftdetailControllergriddata'))->name('shifttiming');
Route::post('shifttimingssave',array('as' => '','check'=>'','menu'=>'shifttiming','label'=>'','uses' =>'ShiftdetailController@store'))->name('shifttiming');
Route::get('/timing/delete/',array('as' => '','check'=>'delete','menu'=>'shifttiming','label'=>'delete','uses' =>'ShiftdetailController@delete'))->name('shifttiming');

/** Document **/
Route::get('documents',array('as' => '','check'=>'','menu'=>'documents','label'=>'','uses' =>'AgencyController@documentindex'))->name('documents');
Route::get('renewal',array('as' => '','check'=>'','menu'=>'renewal','label'=>'','uses' =>'AgencyController@documentindex'))->name('renewal');
Route::post('documentcreate',array('as' => '','check'=>'create','menu'=>'documents','label'=>'Create','uses' =>'AgencyController@documentcreate'))->name('documentcreate');
Route::post('documentrenewal',array('as' => '','check'=>'renewal','menu'=>'renewal','label'=>'Create','uses' =>'AgencyController@documentrenewelcreate'))->name('documentrenewal');
Route::get('renewalData',array('as' => '','check'=>'','menu'=>'renewal','label'=>'','uses' =>'AgencyController@getrenewalData'))->name('getrenewalData');
Route::get('documentData',array('as' => '','check'=>'','menu'=>'documents','label'=>'','uses' =>'AgencyController@getdocumentData'))->name('getdocumentData');
Route::post('documentsave',array('as' => '','check'=>'','menu'=>'documents','label'=>'','uses' =>'AgencyController@documentsave'))->name('documentsave');
//Route::get('documentcreate/{id}',array('as' => '','check'=>'edit','menu'=>'documents','label'=>'Create','uses' =>'AgencyController@documentcreate'))->name('documentcreate');
Route::get('documentdelete/{id}', array('as' => '','check'=>'delete','menu'=>'documents','label'=>'delete','uses' =>'AgencyController@documentdestroy'))->name('documentdestroy');
Route::post('documentview', array('as' => '','check'=>'View','menu'=>'documents','label'=>'view','uses' =>'AgencyController@documentview'))->name('documentview');
 
 

?>