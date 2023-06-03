<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(UserRequest $request)
    {
        return DataTables::of(User::limit($request->limit))->make(true);
    }
}
