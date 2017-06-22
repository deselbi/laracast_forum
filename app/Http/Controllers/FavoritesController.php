<?php

namespace App\Http\Controllers;

use App\Favorite;
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

        $data = [
            'user_id' => Auth::id(),
            'favorited_id' => $id,
            'favorited_type' => $className
        ];

        if( Favorite::where($data)->exists() ) {
            return;
        }

        Favorite::Create($data);

    }
}
