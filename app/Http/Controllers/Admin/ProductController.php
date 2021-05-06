<?php

namespace App\Http\Controllers\Admin;
use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Language;
use Illuminate\Support\Str;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $defult_lang=App::getLocale();
        $products=Product::where('translation_lang',$defult_lang)->selection()->get();

        return view('Admin.products.index',compact('products'));

    }

    public function create()
    {
        $defult_lang=App::getLocale();
        $mainCategories=MainCategory::where('translation_lang',$defult_lang)->selection()->get();
        $subCategories=SubCategory::where('translation_lang',$defult_lang)->selection()->get();
        $getLangouge=Language::selection()->get();
        return view('Admin.products.create',compact('mainCategories','subCategories','getLangouge'));
    }

    public function store(Request $request)
    {

        try{
            $products = collect($request->category);

            $filter = $products->filter(function ($value, $key) {
                return $value['abbr'] ==App::getLocale();
            });

            $default_product = array_values($filter->all()) [0];

            if (!$request->has('category.0.active'))
            $request->request->add(['active' => 0]);
            else
            $request->request->add(['active' => 1]);

            $filePath = "";
            if ($request->has('photo')) {

                $request->photo->store('/', 'products');
                $filename = $request->photo->hashName();
                $filePath = 'images/' . 'products' . '/' . $filename;
            }
            $default_product_id = Product::insertGetId([
                'translation_lang' => $default_product['abbr'],
                'translation_of' => 0,
                'name' => $default_product['name'],
                'description' =>$default_product['description'],
                'subcategory_id' => $request->subcategory_id,
                'active' => $request->active,
                'purchase_price' => $request->purchase_price,
                'sale_price' => $request->sale_price,
                'stock' => $request->stock,
                'category_id'=>$request->category_id,
                'photo' =>$filePath

            ]);

            $otherProducts = $products->filter(function ($value, $key) {
                return $value['abbr'] != App::getLocale();
            });
            if (isset($otherProducts) && $otherProducts->count()) {

                $otherProducts_arr = [];
                foreach ($otherProducts as $product) {
                    $otherProducts_arr[] = [
                        'translation_lang' => $product['abbr'],
                        'translation_of' => $default_product_id,
                        'name' => $product['name'],
                        'description' =>$product['description'],
                        'active' => $request->active,
                        'category_id'=>$request->category_id,
                        'purchase_price' => $request->purchase_price,
                        'sale_price' => $request->sale_price,
                        'stock' => $request->stock,
                        'subcategory_id' => $request->subcategory_id,
                        'photo' =>$filePath
                    ];
                     }
                   }
                   Product::insert($otherProducts_arr);
                return redirect()->route('admin.products')->with(['success' => 'تم الحفظ بنجاح']);
        }

        catch (\Exception $ex)
        {
            return $ex;
            return redirect()->route('admin.products')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
    public function edit($id)
    {
        $defult_lang=App::getLocale();
        $product = Product::where('translation_lang',$defult_lang)
        ->selection()
        ->find($id);
        $mainCategories=MainCategory::where('translation_lang',$defult_lang)->selection()->get();
        $subCategories=SubCategory::where('translation_lang',$defult_lang)->selection()->get();
        $getLangouge=Language::selection()->get();
        if (!$product)
            return redirect()->route('admin.products')->with(['error' => 'هذا القسم غير موجود ']);

        return view('admin.products.edit', compact('product','mainCategories','subCategories','getLangouge'));
    }

    public function update(Request $request)
    {
        return $request;
    }
    public function destroy($id)
    {
        try{
            $products=  Product::find($id);

            if (!$products)
            return redirect()->route('admin.products')->with(['error' => 'هذا القسم غير موجود ']);

            $product_maincatagory=$products->category();

            if(isset($product_maincatagory) && $product_maincatagory->count() > 0)
            {
              return redirect()->route('admin.products')->with(['error' => 'لأ يمكن حذف هذا القسم  ']);
            }
            $product_subcatagory=$products->subcategory();

            if(isset($product_subcatagory) && $product_subcatagory->count() > 0)
            {
              return redirect()->route('admin.products')->with(['error' => 'لأ يمكن حذف هذا القسم  ']);
            }
          /*  // delete photo// */
             $image = Str::after($products->photo, 'assets/');
            $image = base_path('public/assets/' . $image);
             unlink($image);

             $products->translation()->delete();
             $products->delete();

            return redirect()->route('admin.products')->with(['success' => 'تم حذف القسم بنجاح']);
             }

                 catch (\Exception $ex) {

             return redirect()->route('admin.products')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
                 }
    }


}
