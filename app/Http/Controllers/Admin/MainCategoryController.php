<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Repository\RepositoryServices\RepositoryInterfaceService;
use App\Repository\RepositoryServices\RepositoryService;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use App;
use App\Http\Requests\RequestMainCategory;
class MainCategoryController extends Controller
{
    protected $mainCategory;
    public function  __construct( RepositoryInterfaceService $mainCategory)
    {
        $this->mainCategory=$mainCategory;

    }

    public function index()
    {
       return $this->mainCategory->getMainCategory();
    }


    public function create()
    {
        return $this->mainCategory->createMainCategory();

    }


    public function store(RequestMainCategory $request)
    {

         try{
            $main_categories = collect($request->category);

            $filter = $main_categories->filter(function ($value, $key) {
                return $value['abbr'] ==App::getLocale();
            });

            $default_category = array_values($filter->all()) [0];


            if (!$request->has('category.0.active'))
            $request->request->add(['active' => 0]);
            else
            $request->request->add(['active' => 1]);


             


             $filePath = "";
            if ($request->has('photo')) {

                $request->photo->store('/', 'maincategories');
                $filename = $request->photo->hashName();
                $filePath = 'images/' . 'maincategories' . '/' . $filename;
            }


          $default_category_id = MainCategory::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'active' => $request->active,
                'photo' =>$filePath

            ]);

            $categories = $main_categories->filter(function ($value, $key) {
                return $value['abbr'] != App::getLocale();
            });
            if (isset($categories) && $categories->count()) {

                $categories_arr = [];
                foreach ($categories as $category) {
                    $categories_arr[] = [
                        'translation_lang' => $category['abbr'],
                        'translation_of' => $default_category_id,
                        'name' => $category['name'],
                        'slug' => $category['name'],
                        'active' => $request->active,
                        'photo' =>$filePath
                    ];
                     }
                   }
                MainCategory::insert($categories_arr);
                return redirect()->route('admin.maincategories')->with(['success' => 'تم الحفظ بنجاح']);
                    }
                    catch (\Exception $ex)
                    {
                        return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
                    }

    }



     public function edit( $mainCat_id)
    {
        return $this->mainCategory->editMainCategory($mainCat_id);
    }


    public function update(RequestMainCategory $request, $mainCat_id)
    {
        try {
            $main_category = MainCategory::find($mainCat_id);

            if (!$main_category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

            // update date

            $category = array_values($request->category) [0];

            if (!$request->has('category.0.active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);


            MainCategory::where('id', $mainCat_id)
                ->update([
                    'name' => $category['name'],
                    'active' => $request->active,
                ]);

            // save image
            $filePath = "";
            if ($request->has('photo')) {

                $request->photo->store('/', 'maincategories');
                $filename = $request->photo->hashName();
                $filePath = 'images/' . 'maincategories' . '/' . $filename;
                MainCategory::where('id', $mainCat_id)
                    ->update([
                        'photo' => $filePath,
                    ]);
            }




            return redirect()->route('admin.maincategories')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }


    public function destroy($id)
    {
        return $this->mainCategory->deleteMainCategory($id);
    }

    public function changeStatus($id)
    {
        return $this->mainCategory->changeStatusMainCategory($id);
    }
}
