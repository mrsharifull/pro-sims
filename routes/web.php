<?php

use App\Http\Controllers\Backend\Setup\AcademicDivisionController;
use App\Http\Controllers\Backend\Setup\BloodgroupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


use App\Http\Controllers\Backend\UserManagementController;
use App\Http\Controllers\Backend\Setup\ClassController;
use App\Http\Controllers\Backend\Setup\SectionController;
use App\Http\Controllers\Backend\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();


//================================================//
//             White Dashboad Routes              //
//================================================//
Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});


//================================================//
//                   Custom Routes                //
//================================================//
Route::get('/dashboard', 'App\Http\Controllers\HomeController@index')->name('dashboard')->middleware('auth');
Route::group(['middleware' => ['auth', 'permission']], function () {

	Route::get('/export-permissions', function () {
		$filename = 'permissions.csv';
		$filePath = createCSV($filename);
	
		return Response::download($filePath, $filename);
	})->name('export.permissions');

	// User Management Routes 
	Route::group(['as' => 'um.', 'prefix' => 'user-management'], function () {
		Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
			Route::get('index', [UserManagementController::class, 'index'])->name('user_list');
			Route::get('details/{id}', [UserManagementController::class, 'details'])->name('details.user_list');
			Route::get('create', [UserManagementController::class, 'create'])->name('user_create');
			Route::post('create', [UserManagementController::class, 'store'])->name('user_create');
			Route::get('edit/{id}', [UserManagementController::class, 'edit'])->name('user_edit');
			Route::put('edit/{id}', [UserManagementController::class, 'update'])->name('user_edit');
			Route::get('status/{id}', [UserManagementController::class, 'status'])->name('status.user_edit');
			Route::get('delete/{id}', [UserManagementController::class, 'delete'])->name('user_delete');
		});
		Route::group(['as' => 'permission.', 'prefix' => 'permission'], function () {
			Route::get('index', [UserManagementController::class, 'p_index'])->name('permission_list');
			Route::get('details/{id}', [UserManagementController::class, 'p_details'])->name('details.permission_list');
			Route::get('create', [UserManagementController::class, 'P_create'])->name('permission_create');
			Route::post('create', [UserManagementController::class, 'p_store'])->name('permission_create');
			Route::get('edit/{id}', [UserManagementController::class, 'p_edit'])->name('permission_edit');
			Route::put('edit/{id}', [UserManagementController::class, 'p_update'])->name('permission_edit');
		});
		Route::group(['as' => 'role.', 'prefix' => 'role'], function () {
			Route::get('index', [UserManagementController::class, 'r_index'])->name('role_list');
			Route::get('details/{id}', [UserManagementController::class, 'r_details'])->name('details.role_list');
			Route::get('create', [UserManagementController::class, 'r_create'])->name('role_create');
			Route::post('create', [UserManagementController::class, 'r_store'])->name('role_create');
			Route::get('edit/{id}', [UserManagementController::class, 'r_edit'])->name('role_edit');
			Route::put('edit/{id}', [UserManagementController::class, 'r_update'])->name('role_edit');
			Route::get('delete/{id}', [UserManagementController::class, 'r_delete'])->name('role_delete');
		});

	});

	Route::group(['as' => 'student.', 'prefix' => 'student'], function () {
		Route::get('index', [StudentController::class, 'index'])->name('student_list');
		Route::get('details/{id}', [StudentController::class, 'details'])->name('details.student_list');
		Route::get('create', [StudentController::class, 'create'])->name('student_create');
		Route::post('create', [StudentController::class, 'store'])->name('student_create');
		Route::get('edit/{id}', [StudentController::class, 'edit'])->name('student_edit');
		Route::put('edit/{id}', [StudentController::class, 'update'])->name('student_edit');
		Route::get('status/{id}', [StudentController::class, 'status'])->name('status.student_edit');
		Route::get('delete/{id}', [StudentController::class, 'delete'])->name('student_delete');
	});
		


	// Setup Routes 
	Route::group(['as' => 'setup.', 'prefix' => 'setup'], function () {
		// Class Routes 
		Route::group(['as' => 'class.', 'prefix' => 'class'], function () {
			Route::get('index', [ClassController::class, 'index'])->name('class_list');
			Route::get('details/{id}', [ClassController::class, 'details'])->name('details.class_list');
			Route::get('create', [ClassController::class, 'create'])->name('class_create');
			Route::post('create', [ClassController::class, 'store'])->name('class_create');
			Route::get('edit/{id}', [ClassController::class, 'edit'])->name('class_edit');
			Route::put('edit/{id}', [ClassController::class, 'update'])->name('class_edit');
			Route::get('status/{id}', [ClassController::class, 'status'])->name('status.class_edit');
			Route::get('delete/{id}', [ClassController::class, 'delete'])->name('class_delete');
		});
		Route::group(['as' => 'section.', 'prefix' => 'section'], function () {
			Route::get('index', [SectionController::class, 'index'])->name('section_list');
			Route::get('details/{id}', [SectionController::class, 'details'])->name('details.section_list');
			Route::get('create', [SectionController::class, 'create'])->name('section_create');
			Route::post('create', [SectionController::class, 'store'])->name('section_create');
			Route::get('edit/{id}', [SectionController::class, 'edit'])->name('section_edit');
			Route::put('edit/{id}', [SectionController::class, 'update'])->name('section_edit');
			Route::get('status/{id}', [SectionController::class, 'status'])->name('status.section_edit');
			Route::get('delete/{id}', [SectionController::class, 'delete'])->name('section_delete');
		});
		Route::group(['as' => 'academic_division.', 'prefix' => 'academic-division'], function () {
			Route::get('index', [AcademicDivisionController::class, 'index'])->name('academic_division_list');
			Route::get('details/{id}', [AcademicDivisionController::class, 'details'])->name('details.academic_division_list');
			Route::get('create', [AcademicDivisionController::class, 'create'])->name('academic_division_create');
			Route::post('create', [AcademicDivisionController::class, 'store'])->name('academic_division_create');
			Route::get('edit/{id}', [AcademicDivisionController::class, 'edit'])->name('academic_division_edit');
			Route::put('edit/{id}', [AcademicDivisionController::class, 'update'])->name('academic_division_edit');
			Route::get('status/{id}', [AcademicDivisionController::class, 'status'])->name('status.academic_division_edit');
			Route::get('delete/{id}', [AcademicDivisionController::class, 'delete'])->name('academic_division_delete');
		});

		Route::group(['as' => 'bloodgroup.', 'prefix' => 'bloodgroup'], function () {
			Route::get('index', [BloodgroupController::class, 'index'])->name('bloodgroup_list');
			Route::get('details/{id}', [BloodgroupController::class, 'details'])->name('details.bloodgroup_list');
			Route::get('create', [BloodgroupController::class, 'create'])->name('bloodgroup_create');
			Route::post('create', [BloodgroupController::class, 'store'])->name('bloodgroup_create');
			Route::get('edit/{id}', [BloodgroupController::class, 'edit'])->name('bloodgroup_edit');
			Route::put('edit/{id}', [BloodgroupController::class, 'update'])->name('bloodgroup_edit');
			Route::get('status/{id}', [BloodgroupController::class, 'status'])->name('status.bloodgroup_edit');
			Route::get('delete/{id}', [BloodgroupController::class, 'delete'])->name('bloodgroup_delete');
		});
	});


	
});