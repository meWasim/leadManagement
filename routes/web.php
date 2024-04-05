<?php

// use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::group(['prefix' => 'admin'], function () {
Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::get('/register', function () {
    return redirect('/login');
});

Route::get('/', function () {
    return abort(404);
});

Route::get('/', ['as' => 'home', 'uses' => 'Dashboard_V2_Controller@index',])->middleware(['XSS']);

Route::get('/checkrevenue', 'AnalyticController@checkrevenue')->middleware(['auth', 'XSS',]);

Route::get('/home', ['as' => 'homes', 'uses' => 'Dashboard_V2_Controller@index',])->middleware(['auth', 'XSS',]);
Route::get('/check', 'HomeController@check')->middleware(['auth', 'XSS',]);

Route::get('/profile', ['as' => 'profile', 'uses' => 'UserController@profile',])->middleware(['auth', 'XSS',]);
Route::post('/profile', ['as' => 'update.profile', 'uses' => 'UserController@updateProfile',])->middleware(['auth', 'XSS',]);
Route::post('/profile/password', ['as' => 'update.password', 'uses' => 'UserController@updatePassword',])->middleware(['auth', 'XSS',]);
Route::delete('/profile', ['as' => 'delete.avatar', 'uses' => 'UserController@deleteAvatar',])->middleware(['auth', 'XSS',]);

Route::get('/users', ['as' => 'users', 'uses' => 'UserController@index',])->middleware(['auth', 'XSS',]);
Route::post('/users', ['as' => 'users.store', 'uses' => 'UserController@store',])->middleware(['auth', 'XSS',]);
Route::get('/users/create', ['as' => 'users.create', 'uses' => 'UserController@create',])->middleware(['auth', 'XSS',]);
Route::get('/users/edit/{id}', ['as' => 'users.edit', 'uses' => 'UserController@edit',])->middleware(['auth', 'XSS',]);
Route::get('/users/{id}', ['as' => 'users.show', 'uses' => 'UserController@show'])->middleware(['auth', 'XSS']);
Route::post('/users/{id}', ['as' => 'users.update', 'uses' => 'UserController@update',])->middleware(['auth', 'XSS',]);
Route::delete('/users/{id}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy',])->middleware(['auth', 'XSS',]);
Route::post('/userCreateFromCsv', ['as' => 'userCreateFromCsv', 'uses' => 'UserController@userCreateFromCsv',])->middleware(['auth', 'XSS',]);
Route::post('/profile/userpassword', ['as' => 'update.userpassword', 'uses' => 'UserController@userpassword',])->middleware(['auth', 'XSS',]);
Route::get('/management/pivot', ['as' => 'management.pivot', 'uses' => 'PivotFilterController@index',])->middleware(['auth', 'XSS',]);
Route::post('/management/pivot/update', ['as' => 'management.pivot.update', 'uses' => 'PivotFilterController@update',])->middleware(['auth', 'XSS',]);


Route::post('/template-setting', ['as' => 'template.setting', 'uses' => 'SettingsController@saveTemplateSettings'])->middleware(['auth', 'XSS']);
Route::get('/invoices/preview/{template}/{color}', ['as' => 'invoice.preview', 'uses' => 'InvoiceController@previewInvoice']);
Route::get('/invoices/preview/{template}/{color}', ['as' => 'invoice.preview', 'uses' => 'InvoiceController@previewInvoice']);

Route::post('/site-settings', ['as' => 'site.settings.store', 'uses' => 'SettingsController@site_setting',])->middleware(['auth', 'XSS',]);
Route::get('/ip-settings', ['as' => 'add.ip.client', 'uses' => 'SettingsController@addIp',])->middleware(['auth', 'XSS',]);
Route::get('/ip-settings/{id}', ['as' => 'get.ip.client', 'uses' => 'SettingsController@updateIp',])->middleware(['auth', 'XSS',]);
Route::delete('/ip-settings', ['as' => 'delete.ip.client', 'uses' => 'SettingsController@deleteIp',])->middleware(['auth', 'XSS',]);
Route::put('/ip-settings', ['as' => 'update.ip.client', 'uses' => 'SettingsController@saveUpdateIp',])->middleware(['auth', 'XSS',]);
Route::post('/ip-settings', ['as' => 'store.ip.client', 'uses' => 'SettingsController@storeIp',])->middleware(['auth', 'XSS',]);

Route::get('/settings', ['as' => 'settings', 'uses' => 'SettingsController@index',])->middleware(['auth', 'XSS',]);
Route::post('/settings', ['as' => 'settings.store', 'uses' => 'SettingsController@store',])->middleware(['auth', 'XSS',]);
Route::post('/middleware-settings', ['as' => 'middleware.store', 'uses' => 'SettingsController@middlewareUpdate',])->middleware(['auth', 'XSS',]);

Route::get('/{uid}/notification/seen', ['as' => 'notification.seen', 'uses' => 'UserController@notificationSeen']);

/* fake Router */
Route::post('/message_data', 'SettingsController@savePaymentSettings')->name('message.data')->middleware(['auth', 'XSS']);

Route::post('/message_seen', 'SettingsController@savePaymentSettings')->name('message.seen')->middleware(['auth', 'XSS']);
//================================= Invoice Payment Gateways  ====================================//

Route::get('/search', ['as' => 'search.json', 'uses' => 'UserController@search']);

Route::get('/invoices/payments', ['as' => 'invoices.payments', 'uses' => 'InvoiceController@payments',])->middleware(['auth', 'XSS',]);

Route::resource('roles', 'RoleController');
Route::prefix('roles')->middleware(['auth', 'XSS',])->group(function () {

    Route::get('/{id}/operator', 'RoleController@addOperator')->name('roles.operator')->middleware(['auth', 'XSS',]);
    Route::post('/operator/store', 'RoleController@storeOperator')->name('roles.operator.store')->middleware(['auth', 'XSS',]);
});
Route::resource('permissions', 'PermissionController');

/* Reports Web */

Route::prefix('dashboard')->middleware(['auth', 'XSS',])->group(function () {
    Route::get('/country', 'Dashboard_V2_Controller@index')->name('dashboard.country.tesing');
    Route::get('/operator', 'Dashboard_V2_Controller@operatorDashboard')->name('dashboard.operator');
    Route::get('/company', 'Dashboard_V2_Controller@companyDashboard')->name('dashboard.company');
    Route::get('/business', 'Dashboard_V2_Controller@businessDashboard')->name('dashboard.business');
    /*Route::get('/country', 'DashboardController@index')->name('dashboard.country');
	Route::get('/operator','DashboardController@operatorDashboard')->name('dashboard.operator');
    Route::get('/company', 'DashboardController@companyDashboard')->name('dashboard.company');*/
    Route::post('/getsummarygraphdata', 'Controller@Getsummarygraphdata');
    Route::post('/getmixedgraphaxesdata', 'Controller@Getmixedgraphaxesdata');
    Route::post('/getmixedgraphdata', 'Controller@Getmixedgraphdata');
});




Route::prefix('management')->middleware(['auth', 'XSS',])->group(function () {
    Route::get('/user', 'ManagementController@userManagement')->name('management.user');
    Route::get('/revShare', 'ManagementController@revShareManagement')->name('management.revShare');
    Route::get('/users/{id}/operator/service', 'ManagementController@showUserOperator')->name('users.show.operator');
    Route::post('/user/operator/store', 'ManagementController@userOperatorStore')->name('management.user.operator.store');
    Route::get('/companyAssign', 'ManagementController@companyAssign')->name('management.companyAssign');
    // Route::get('/company', 'ManagementController@companyManagement')->name('management.company');
    Route::get('/company', 'CompanyController@index')->name('management.company');
    Route::get('/add-company/', 'ManagementController@addCompany')->name('management.add-company');
    // Route::get('/edit-company/{id}', 'ManagementController@editCompany')->name('management.edit-company');
    Route::get('/currency', 'ManagementController@currencyManagement')->name('management.currency');
    Route::get('/add-currency/', 'ManagementController@addCurrency')->name('management.add-currency');
    Route::get('/edit-currency/{id}', 'ManagementController@editCurrency')->name('management.edit-currency');
    Route::get('/operator', 'ManagementController@operatorManagement')->name('management.operator');
    Route::get('/operator/{id}/edit', 'ManagementController@operatorNameEdit')->name('management.operator.edit');
    Route::post('/operator/name/update', 'ManagementController@operatorNameUpdate')->name('operator.name.update');
    Route::post('/update_operator', 'ManagementController@update_operator');
    Route::get('/company-operator/{id}', 'CompanyController@addOperator')->name('management.company-operator');
    Route::post('/operator/store', 'CompanyController@store_operator');
    Route::get('/edit-company/{id}', 'CompanyController@editCompany')->name('management.edit-company');
    Route::get('/edit-operator/{id}', 'CompanyController@editOperator')->name('management.edit-operator');
    Route::get('/view-operators/{id}', 'CompanyController@all_com_operators')->name('management.view-operators');
    Route::get('/view-unknown-company', 'CompanyController@all_unknown_operators')->name('management.view-unknown-company');
    // Route::get('/operator', 'OperatorController@index')->name('management.operator');
    Route::get('/rev_share/{id}', 'OperatorController@create_rev_share')->name('management.rev-share');
    Route::post('/updateRev/{id}', ['as' => 'operator.updateRev', 'uses' => 'OperatorController@updateRev_Share',]);
    Route::get('/date/rev/share/{id}', 'OperatorController@createRevshareByDate')->name('management.revShare.date');
    Route::post('/update/rev/date', 'OperatorController@updateRevshareByDate')->name('management.revShare.update.date');
    Route::get('/project', 'ManagementController@projectManagement')->name('project.management');
    // Route::get('/pmo-statistic', 'ManagementController@pmoStatistic')->name('pmo.statistic');
});



Route::prefix('leads')->group(function () {
    Route::get('/', 'LeadController@index')->name('leads.index')->middleware(['auth', 'XSS',]);
    Route::get('/create', 'LeadController@create')->name('leads.create')->middleware(['auth', 'XSS',]);
    Route::post('/store', 'LeadController@store')->name('leads.store')->middleware(['auth', 'XSS',]);
    Route::post('/destroy', 'LeadController@delete')->name('leads.destroy')->middleware(['auth', 'XSS',]);

    
});


Route::middleware(['auth', 'XSS',])->group(function () {
    Route::resources([
        'branches' => BranchController::class, 
    ]);
});
    



Route::get('/error', 'UserController@error')->name('error');

/* Clear application cache: */
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache has been cleared';
});

/* Clear route cache: */
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return 'Routes cache has been cleared';
});

/* Clear config cache: */
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache has been cleared';
});

/* Clear view cache: */
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return 'View cache has been cleared';
});

/* Clear optimize */
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return 'Configuration & Route cache cleared successfully';
});

/* Clear permission cache */
Route::get('/permission-clear', function () {
    $exitCode = Artisan::call('permission:cache-reset');
    return 'Permission cache cleared successfully';
});