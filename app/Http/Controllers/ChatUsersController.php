<?php

namespace App\Http\Controllers;

use App\Models\ChatUsers;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatUsersController extends Controller
{
    public function index()
    {
        return Json::decode(ChatUsers::leftJoin('users', 'user_id', '=', 'users.id')
            ->whereNot('user_id', auth()->id())->groupBy('user_id')
            ->get());
    }
}
