<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @param int $id
     * @param string $type
     */
    public function store(int $id, string  $type)
    {
        $className = 'App\\' . ucfirst($type);


        $className::find($id)->favorite();
        return back();

    }
}
