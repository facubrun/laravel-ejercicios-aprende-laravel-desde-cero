<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/contact', fn () => Response::view('contact'));

Route::post('/contact', function(Request $request){
    dd($request);
});

Route::post('/ejercicio2/a', fn(Request $request) => Response::json($request->all()));

Route::post('/ejercicio2/b', function(Request $request) {
    if($request->json('price') <= 0) {
        return Response::json(['message' => 'Price can\'t be less than 0'], 422);
    } else {
        return Response::json($request->all());
    }
});

Route::post('/ejercicio2/c', function(Request $request) {
    $discount_code = $request->query('discount');
    $discount = preg_match('/SAVE(\d{1,2})/', $discount_code, $matches);
    $request_data = $request->all();
    
    if($discount > 0) {
        $discount = (int)$matches[1];
        $price = $request->input('price');
        $discounted_price = $price - ($price * ($discount / 100));
        
        $request_data['price'] = $discounted_price;
        $request_data['discount'] = $discount;
        
    } else {
        $request_data['discount'] = 0;
    }
    
    return Response::json($request_data);
});
