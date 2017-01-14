<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/barcode/{data}', function (Request $request, $data) {

    // Generate EAN-128 barcode
    $ean = new \App\EAN128();
    $im = $ean->generateImage($data, 6);

    header('Content-Type: image/png');

    ob_start();
    imagepng($im);
    $imageData = ob_get_contents();
    ob_end_clean();

    imagedestroy($im);

    return Response::make($imageData)->header('Content-Type', 'image/png');
});
