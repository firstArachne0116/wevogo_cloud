<?php

namespace App\Http\Controllers;

use App\Model\WevoUser;
use Illuminate\Http\Request;

class WevoUsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['wevoUsers'] = WevoUser::paginate(10);
        return view('wevo-users.index', $data);
    }
}
