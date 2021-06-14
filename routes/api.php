<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminVacController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryNewsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacCenterController;
use App\Http\Controllers\VaccinesController;
use App\Http\Controllers\VacStatusController;
use App\Http\Controllers\VideoDocumentationController;
use App\Models\CategoryNews;
use Illuminate\Database\Console\Migrations\StatusCommand;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:admin-api')->group(function() {
    Route::get('auth/admin', [AuthController::class, 'getAuthAdmin']);
    Route::resource('admin/category/news', CategoryNewsController::class);
    Route::resource('admin/news', NewsController::class);
    Route::resource('admin/vaccines', VaccinesController::class);
    Route::resource('admin/stock', StockController::class);
    Route::resource('admin/vac/status', VacStatusController::class);
    Route::resource('admin/vaccenter', VacCenterController::class);
    Route::resource('admin/vac/schedule', ScheduleController::class);
    Route::resource('admin/profile', AdminController::class);
    Route::post('admin/vaccenter/{id}/join/schedule', [VacCenterController::class, 'storeRelation']);
    Route::post('admin/vaccenter/{id}/leave/schedule', [VacCenterController::class, 'destroyRelation']);    
});

Route::middleware('auth:adminvac-api')->group(function() {
    Route::get('auth/adminvac', [AuthController::class, 'getAuthAdmin']);
    Route::resource('adminvac/category/news', CategoryNewsController::class);
    Route::resource('adminvac/news', NewsController::class);
    Route::resource('adminvac/vaccines', VaccinesController::class);
    Route::resource('adminvac/stock', StockController::class);
    Route::resource('adminvac/vac/status', VacStatusController::class);
    Route::resource('adminvac/vaccenter', VacCenterController::class);
    Route::resource('adminvac/vac/schedule', ScheduleController::class);
    Route::resource('adminvac/profile', AdminController::class);
    Route::post('adminvac/vaccenter/{id}/join/schedule', [VacCenterController::class, 'storeRelation']);
    Route::post('adminvac/vaccenter/{id}/leave/schedule', [VacCenterController::class, 'destroyRelation']);    
});

Route::middleware('auth:adminvac-api')->group(function() {
    Route::resource('vaccenter', VacCenterController::class);
    Route::post('vaccenter/{id}/add/schedule', [VacCenterController::class, 'storeRelation']);
    Route::post('vaccenter/{id}/remove/schedule', [VacCenterController::class, 'destroyRelation']);
    
    Route::resource('stock', StockController::class);
    
    Route::resource('vaccines', VaccinesController::class);
    Route::post('vaccines/{id}/add/participant', [VaccinesController::class, 'storeRelation']);
    Route::post('vaccines/{id}/remove/participant', [VaccinesController::class, 'destroyRelation']);
    
    Route::resource('status', VacStatusController::class);
    Route::post('status/{id}/add/participant', [VacStatusController::class, 'storeRelation']);
    Route::post('status/{id}/remove/participant', [VacStatusController::class, 'destroyRelation']);
    
    Route::resource('participant/general', PesertaController::class);
    Route::post('participant/{id}/add/vaccines', [PesertaController::class, 'storeRelation']);
    Route::post('participant/{id}/remove/vaccines', [PesertaController::class, 'destroyRelation']);
    Route::post('participant/{id}/add/status', [PesertaController::class, 'storeRelationStatus']);
    Route::post('participant/{id}/remove/status', [PesertaController::class, 'destroyRelationStatus']);
    
    Route::resource('schedule/vac', ScheduleController::class);
    Route::post('schedule/{id}/add/vaccenter', [ScheduleController::class, 'storeRelation']);
    Route::post('schedule/{id}/remove/vaccenter', [ScheduleController::class, 'destroyRelation']);
    
    Route::resource('category/news/data', CategoryNewsController::class);

    Route::get('auth/adminvac', [AuthController::class, 'getAuthAdminVac']);    

    Route::resource('news', NewsController::class);
});

Route::middleware(['auth:peserta-api'])->group(function() {
    Route::get('auth/peserta', [AuthController::class, 'getAuth']);
    Route::resource('participant/profile', PesertaController::class);
    Route::get('participant/vac/status', [VacStatusController::class, 'index']);
    Route::post('participant/join/vac/status/{id}', [PesertaController::class, 'storeRelationStatus']);
    Route::post('participant/leave/vac/status/{id}', [PesertaController::class, 'destroyRelationStatus']);
    Route::post('participant/join/vaccines/{id}', [PesertaController::class, 'storeRelation']);
    Route::post('participant/leave/vaccines/{id}', [PesertaController::class, 'destroyRelation']);
    Route::patch('participant/join/vaccenter', [VacCenterController::class, 'update']);
    Route::get('participant/vaccines', [VaccinesController::class, 'index']);
    Route::get('participant/news', [NewsController::class, 'index']);
    Route::get('participant/news/{id}', [NewsController::class, 'show']);
    Route::get('participant/category/news', [CategoryNewsController::class, 'index']);
});

Route::get('participant/vaccenter', [VacCenterController::class, 'index']);

Route::resource('admin/vaccenter/private', AdminVacController::class);
Route::resource('admin/general/private', AdminController::class);

Route::post('login/admin/general/private', [AuthController::class, 'loginAdminGeneral']);
Route::post('login/admin/vaccenter/private', [AuthController::class, 'loginAdminVac']);
Route::post('login/participant/general', [AuthController::class, 'loginGeneral']);
Route::post('signup/participant/general', [PesertaController::class, 'store']);

Route::resource('video/documentation', VideoDocumentationController::class);

// Unused
// Route::resource('user/general', UserController::class);
