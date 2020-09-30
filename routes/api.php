<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
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
    $rowsPerPage = $request->rowsPerPage ? (int) $request->rowsPerPage : 5;
    return User::when($request->search, function($query) use ($request) {
        $query->where('name', $request->search);
    })->paginate($rowsPerPage);
});
