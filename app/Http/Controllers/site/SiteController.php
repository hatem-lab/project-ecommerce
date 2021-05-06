<?php

namespace App\Http\Controllers\site;
use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Vendor;
use App\Models\MainCategory;
use App\Models\Slider;
use App\Models\SubCategory;
class SiteController extends Controller
{
    public function index()
    {
        $defult_lang=App::getLocale();
        ///////Slider/////////////////
        $sliders=Slider::all();

        //////Data  Category/////////////////////////
       $categories=MainCategory::with(['subCategories'=>function($q){
            $q->with(['subcategorychildren']);
        }])->where('translation_lang',$defult_lang)->selection()->get();
        return view('front.home',compact('categories','sliders'));

        /////////////Data Product///////////////////

    }
    public function productsBySlug($name)
    {

       //return  $category;
        $defult_lang=App::getLocale();
         $category=MainCategory::where('translation_lang',$defult_lang)->where('name',$name)->get();
         //return  $category;
        return view('front.products', compact('category'));
    }

}
