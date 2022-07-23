<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('companies/getAllCompanies', [CompanyController::class, 'getAllCompanies']); // ------ publicly available route ----------

Route::middleware(['auth:api'])->group(function () {
    Route::group(['prefix' => 'companies', 'as' => 'companies.'], function () {
        // Route::get('', [CompanyController::class, 'getAllCompanies'])->name('get');  ------- authenticated route ----------
        Route::post('', [CompanyController::class, 'insertCompany'])->name('store');
    });


    Route::group(['prefix' => 'departments', 'as' => 'departments.'], function () {
        Route::post('', [DepartmentController::class, 'insertDepartment'])->name('store');
        Route::post('/getCompanyDepartments', [DepartmentController::class, 'getCompanyDepartments'])->name('getCompanyDepartments');
    });

    Route::group(['prefix' => 'employees', 'as' => 'employees.'], function () {
        Route::post('', [EmployeeController::class, 'insertEmployee'])->name('store');
    });
});
