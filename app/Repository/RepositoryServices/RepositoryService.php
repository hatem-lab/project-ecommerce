<?php
namespace App\Repository\RepositoryServices;
use App\Repository\RepositoryServices\RepositoryInterfaceService;
use App\Repository\RepositoryServices\RepositoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use App\Models\Language;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Vendor;
use App;
class RepositoryService implements RepositoryInterfaceService
{
     /* for lannguages  */

public function getLanguage()
{
    $languages=Language::all();
    return view('admin.languages.index',compact('languages'));
}


public function createLanguage()
{
    return view('admin.languages.create');
}



public function storeLanguage(array $data)
{
    try {

        $language= Language::create($data);

         return redirect()->route('admin.languages')->with(['success' => 'تم حفظ اللغة بنجاح']);
     }
      catch (\Exception $ex) {
         return redirect()->route('admin.languages')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
     }
}



public function editLanguage($id)
{
    $language = Language::find($id);
    return view('admin.languages.edit',compact('language'));
}



public function updateLanguage($id,array $data)
{
    try{
        $language = Language::find($id);
        $language->update($data);

            return redirect()->route('admin.languages')->with(['success' => 'تم تحديث اللغة بنجاح']);
           }
         catch (\Exception $ex)
          {

        return redirect()->route('admin.languages')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);

       }
}
public function deleteLanguage($id)
{
    $language = Language::find($id);
    $language->delete();

    return redirect()->route('admin.languages');
}

/* --------------------------------------------------------------------------------------------------- */


/* for MainCategories  */

public function getMainCategory()
{
    $defult_lang=App::getLocale();
    $mainCategories=MainCategory::where('translation_lang',$defult_lang)->selection()->get();
    return view('admin.mainCategories.index',compact('mainCategories','defult_lang'));
}


public function createMainCategory()

{
    $getLangouge= Language::active()->selection()->get();
    return view('admin.mainCategories.create',compact('getLangouge'));

}
public function storeMainCategory(array $data)
{
}
public function editMainCategory($id)
{
    $mainCategory = MainCategory::with('categories')
        ->selection()
        ->find($id);

        if (!$mainCategory)
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

        return view('admin.maincategories.edit', compact('mainCategory'));
}
public function updateMainCategory($id,array $data)
{}



public function deleteMainCategory($id)
{
    try{
        $mainCategory=  MainCategory::find($id);

        if (!$mainCategory)
        return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

        $vendors=$mainCategory->vendors();

        if(isset($vendors) && $vendors->count() > 0)
        {
          return redirect()->route('admin.maincategories')->with(['error' => 'لأ يمكن حذف هذا القسم  ']);
        }
      /*  // delete photo// */
         $image = Str::after($mainCategory->photo, 'assets/');
        $image = base_path('public/assets/' . $image);
         unlink($image);

         $mainCategory->categories()->delete();
         $mainCategory->delete();

        return redirect()->route('admin.maincategories')->with(['success' => 'تم حذف القسم بنجاح']);
         }

             catch (\Exception $ex) {

         return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
             }

}

public function changeStatusMainCategory($id)
{
    try{
        $mainCategory=  MainCategory::find($id);

        if (!$mainCategory)
        return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);
        $status =  $mainCategory -> active  == 0 ? 1 : 0;

        $mainCategory -> update(['active' =>$status ]);
        return redirect()->route('admin.maincategories')->with(['success' => ' تم تغيير الحالة بنجاح ']);

    }
    catch (\Exception $ex) {

        return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
    }
}

/* --------------------------------------------------------------------------------------------------- */
/* for SubCategories  */
public function getSubCategory()
{
    $defult_lang=App::getLocale();
    $subCategories=SubCategory::where('translation_lang',$defult_lang)->selection()->get();
    return view('admin.subcategories.index',compact('subCategories','defult_lang'));
}
public function createSubCategory()
{
    $defult_lang=App::getLocale();
    $mainCategories=MainCategory::where('translation_lang',$defult_lang)->selection()->get();
    $subCategories=SubCategory::where('translation_lang',$defult_lang)->selection()->get();
    $getLangouge= \App\Models\Language::active()->selection()->get();
    return view('admin.subcategories.create',compact('getLangouge','mainCategories','subCategories'));
}
public function storeSubCategory(array $data)
{}
public function editSubCategory($id)
{
    $subCategory = SubCategory::with('categories')
    ->selection()
    ->find($id);

    if (!$subCategory)
        return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

    return view('admin.subcategories.edit', compact('subCategory'));
}


public function updateSubCategory($id,array $data)
{}


public function deleteSubCategory($id)
{
    try{
        $subCategory=  SubCategory::find($id);

        if (!$subCategory)
        return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

        $subCategoeyChild=$subCategory->subcategorychild();

        if(isset($subCategoeyChild) && $subCategoeyChild->count() > 0)
        {
          return redirect()->route('admin.subcategories')->with(['error' => 'لأ يمكن حذف هذا القسم  ']);
        }
      /*  // delete photo// */
         $image = Str::after($subCategory->photo, 'assets/');
        $image = base_path('public/assets/' . $image);
         unlink($image);

         $subCategory->categories()->delete();
         $subCategory->delete();

        return redirect()->route('admin.subcategories')->with(['success' => 'تم حذف القسم بنجاح']);
         }

             catch (\Exception $ex) {

         return redirect()->route('admin.subcategories')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
             }
}



public function changeStatusSubCategory($id)
{
    try{
        $subCategory=  SubCategory::find($id);

        if (!$subCategory)
        return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);
        $status =  $subCategory -> active  == 0 ? 1 : 0;

        $subCategory -> update(['active' =>$status ]);
        return redirect()->route('admin.subcategories')->with(['success' => ' تم تغيير الحالة بنجاح ']);

    }
    catch (\Exception $ex) {
        return $ex;
        return redirect()->route('admin.subcategories')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
    }
}


/* --------------------------------------------------------------------------------------------------- */
/* for Vendors  */

public function getVendors()
{
    $vendors = Vendor::selection()->paginate(10);
    return view('admin.vendors.index', compact('vendors'));
}

public function createVendors()
{
    $categories = MainCategory::where('translation_of', 0)->active()->get();
    return view('admin.vendors.create', compact('categories'));
}

public function storeVendors(array $data)
{}

public function editVendors($id)
{
    try {

        $vendor = Vendor::Selection()->find($id);
        if (!$vendor)
            return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود او ربما يكون محذوفا ']);

        $categories = MainCategory::where('translation_of', 0)->active()->get();

        return view('admin.vendors.edit', compact('vendor', 'categories'));

    } catch (\Exception $exception) {
        return redirect()->route('admin.vendors')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
    }
}
public function updateVendors($id,array $data)
{}

public function deleteVendors($id)
{
    try {

        $vendor = Vendor::Selection()->find($id);
        if (!$vendor)
            return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود  ']);
       $image = Str::after($vendor->logo, 'assets/');
       $image = base_path('public/assets/' . $image);
       unlink($image);
       $vendor->delete();
            return redirect()->route('admin.vendors')->with(['success' => 'تم حذف القسم بنجاح']);
        }
       catch(\Exception $exception )
        {
            return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود او ربما يكون محذوفا ']);
          }
}


public function changeStatusVendors($id)
{
    try{
        $vendor = Vendor::Selection()->find($id);

        if (!$vendor)
        return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود  ']);

        $status =  $vendor -> active  == 0 ? 1 : 0;

        $vendor -> update(['active' =>$status ]);
        return redirect()->route('admin.vendors')->with(['success' => ' تم تغيير الحالة بنجاح ']);

    }
    catch (\Exception $ex) {

        return redirect()->route('admin.vendors')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
    }
}

}
