<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\AdminPermission;
use App\Http\Middleware\Deneme;
use App\Http\Middleware\ModeratorPermission;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\UserPermission;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/dashboard', function () {
    return response()->json([
        'message' => 'Welcome to Stock Management API',
        'status' => 'Connected'
    ]);
});


Route::prefix('report')->middleware('auth:sanctum')->group(function () {
    Route::get('/',  [ReportController::class, 'index']);
    Route::get('/user',  [ReportController::class, 'getUserReports']);
    Route::get('/{id}',  [ReportController::class, 'getReportById']);
    Route::get('/yearly',  [ReportController::class, 'getYearlyReport']);
    Route::get('/monthly',  [ReportController::class, 'getMonthlyReport']);
    Route::get('/weekly',  [ReportController::class, 'getWeeklyReport']);
    Route::get('/daily',  [ReportController::class, 'getDailyReport']);
    Route::get('/custom/day/{day}',  [ReportController::class, 'getCustomDayReport']);
    Route::get('/custom/month/{month}',  [ReportController::class, 'getCustomMonthReport']);
    Route::get('/custom/year/{year}',  [ReportController::class, 'getCustomYearReport']);
    Route::get('/custom/time-range/{start}/{end}',  [ReportController::class, 'getCustomTimeRangeReport']);
});

Route::prefix('transaction')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TransactionController::class, 'list']);
    Route::get('/user', [TransactionController::class, 'getTransactionByUser']);
    Route::get('/{id}', [TransactionController::class, 'show']);
    Route::put('/{id}', [TransactionController::class, 'update']);
    Route::delete('/{id}', [TransactionController::class, 'destroy']);
});

Route::prefix('stock')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [StockController::class, 'list']);
    Route::post('/', [StockController::class, 'store']);
    Route::get('/{id}', [StockController::class, 'show']);
    Route::put('/{id}', [StockController::class, 'update']);
    Route::delete('/{id}', [StockController::class, 'destroy']);
    Route::post('/increase/{id}', [StockController::class, 'increase']);
    Route::post('/decrease/{id}', [StockController::class, 'decrease']);
    Route::post('/search', [StockController::class, 'search']);
});

Route::prefix('category')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CategoryController::class, 'list']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('image')->middleware('auth:sanctum')->group(function() {
    Route::post('/upload', [ImageController::class, 'upload']);
    Route::delete('/delete', [ImageController::class, 'delete']);
    Route::put('/update', [ImageController::class, 'update']);
    Route::get('/show', [ImageController::class, 'show']);
});

Route::prefix('/admin')->middleware([AdminPermission::class])->group(function() {
    Route::get('/', function() {
        return response()->json([
            'message' => 'Welcome to Admin Panel',
            'status' => 'Connected'
        ]);
    });
});


Route::prefix('/role')->middleware(ModeratorPermission::class)->group(function() {
    Route::post('/', [RoleController::class, 'AttachRole']);
    Route::get('/roles', [RoleController::class, 'RoleList']);
    Route::get('/user-roles', [RoleController::class, 'UserRoleList']);
    Route::get('/{id}', [RoleController::class, 'returnUserRole']);
});


Route::prefix('/moderator')->middleware([ModeratorPermission::class])->group(function() {
    Route::get('/', function() {
        return response()->json([
            'message' => 'Welcome to Moderator Panel',
            'status' => 'Connected'
        ]);
    });
});

Route::prefix('/user')->middleware(UserPermission::class)->group(function() {
    Route::get('/', function() {
        return response()->json([
            'message' => 'Welcome to User Panel',
            'status' => 'Connected'
        ]);
    });
});
