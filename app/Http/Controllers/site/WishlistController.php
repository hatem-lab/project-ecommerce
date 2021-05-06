<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
       $products =  auth()->user()
            ->wishlist()
            ->latest()
            ->get();   // task for you basically we need to use pagination here
        return view('front.wishlists', compact('products'));
    }
    public function store(Request $request)
    {
              $data=request('productId');

             if (! auth()->user()->wishlistHas(request('productId'))) {
                auth()->user()->wishlist()->attach(request('productId'));
                return response() -> json(['status' => true , 'wished' => true]);
            }
            return response() -> json(['status' => true , 'wished' => false]);
       // return response() -> json($['status' => true , 'wished' => false]);  // added before we can use enumeration here
    }
    public function destroy($id)
    {

        auth()->user()->wishlist()->where('id',$id)->detach($id);
    }
}
