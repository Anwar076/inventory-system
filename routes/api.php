<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\ProductController as ApiProductController;
use App\Http\Controllers\Api\V1\StockController as ApiStockController;
use App\Http\Controllers\Api\V1\CategoryController as ApiCategoryController;
use App\Http\Controllers\Api\V1\SupplierController as ApiSupplierController;
use App\Http\Controllers\Api\V1\ReportController as ApiReportController;
use App\Http\Controllers\Api\V1\UserController as ApiUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Str;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/notifications', function (Request $request) {
    return $request->user()->notifications()->limit(20)->get();
});

Route::middleware('auth:sanctum')->post('/notifications/mark-all-read', function (Request $request) {
    $request->user()->unreadNotifications->markAsRead();
    return response()->json(['status' => 'ok']);
});

Route::middleware('auth:sanctum')->get('/all-notifications', function () {
    return \DB::table('notifications')->orderBy('created_at', 'desc')->limit(50)->get();
});

Route::post('/low-stock-proposals/{proposal}/approve', function (Request $request, $proposal) {
    // Zoek de notificatie met dit proposal_id
    $notification = DB::table('notifications')->where('data', 'like', '%"proposal_id":"' . $proposal . '"%')->first();
    if (!$notification) {
        return response()->json(['message' => 'Voorstel niet gevonden.'], 404);
    }
    $data = json_decode($notification->data, true);
    $product = Product::find($data['product_id'] ?? null);
    if (!$product) {
        return response()->json(['message' => 'Product niet gevonden.'], 404);
    }
    // Maak een voorraadtransactie aan (voorbeeld: 10 stuks bijbestellen)
    StockTransaction::create([
        'product_id' => $product->id,
        'type' => 'restock',
        'quantity' => 10,
        'total_amount' => 0,
        'transaction_date' => now(),
    ]);
    // Markeer notificatie als gelezen
    DB::table('notifications')->where('id', $notification->id)->update(['read_at' => now()]);
    return response()->json(['message' => 'Transactie aangemaakt en voorstel goedgekeurd.']);
});

Route::post('/low-stock-proposals/{proposal}/reject', function (Request $request, $proposal) {
    $notification = DB::table('notifications')->where('data', 'like', '%"proposal_id":"' . $proposal . '"%')->first();
    if (!$notification) {
        return response()->json(['message' => 'Voorstel niet gevonden.'], 404);
    }
    DB::table('notifications')->where('id', $notification->id)->update(['read_at' => now()]);
    return response()->json(['message' => 'Voorstel afgekeurd.']);
});

Route::prefix('v1')->middleware(['auth:sanctum', 'tenant'])->group(function () {
    Route::apiResource('products', ApiProductController::class);
    Route::apiResource('stock', ApiStockController::class);
    Route::apiResource('categories', ApiCategoryController::class);
    Route::apiResource('suppliers', ApiSupplierController::class);
    Route::apiResource('users', ApiUserController::class);
    Route::get('reports', [ApiReportController::class, 'index']);
}); 