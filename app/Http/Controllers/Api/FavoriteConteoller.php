<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\favouritResource;
class FavoriteConteoller extends Controller
{
 
    public function store(Request $request)
    {
  
   
        $favo=Favorite::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id
         ]);
        
        return response()->json(['book added successfully.']);
    
    }

 
    public function index()
    {
    
    
        $fav =Favorite::join('books', 'books.id', '=', 'favorites.book_id')
        ->select('favorites.id', 'books.name','books.description')->where('favorites.user_id',Auth::id())
        ->get();
        if (is_null($fav)) {
            return response()->json('Data not found', 404); 
        }



        return response()->json(favouritResource::collection($fav));

    }




 
    public function destroy(Favorite $favorite)
    {
    $favorite->delete();
    return "deleted done";
    }
}
