<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/user', function (Request $request) {
    $rowsPerPage = $request->rowsPerPage ? (int) $request->rowsPerPage : 5;

    $query = User::when($request->search, function($query) use ($request) {
        $query->where(function($query) use ($request) {
            $query->orWhere('name', 'like', '%'. $request->search .'%')
            ->orWhere('email', 'like', '%'. $request->search .'%');
        });
    });

    $sortByColumns = explode(',', $request->sortBy);
    $sortOrder = explode(',', $request->sortDesc);

    if($request->sortBy && $request->sortDesc) {
        for($i = 0; $i < count($sortByColumns); $i++) {
            $query->orderBy($sortByColumns[$i], ($sortOrder[$i] === 'true' ? 'desc' : 'asc'));
        }
    }

    return $query->paginate($rowsPerPage);
});
