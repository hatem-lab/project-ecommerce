<?php

namespace App\Http\Controllers\Admin;
use App;
use App\Models\SubCategory;
use App\Models\MainCategory;
use App\Http\Controllers\Controller;
use App\Repository\RepositoryServices\RepositoryInterfaceService;
use App\Repository\RepositoryServices\RepositoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Language;
use App\Http\Requests\RequestMainCategory;
class SubCategoryController extends Controller
{
    protected $subCategory;
    public function  __construct( RepositoryInterfaceService $subCategory)
    {
        $this->subCategory=$subCategory;

    }
    public function index()
    {
      return $this->subCategory->getSubCategory();
    }

    public function create()
    {
        return $this->subCategory->createSubCategory();
    }

    public function store(RequestMainCategory $request)
    {



         try{
            $sub_categories = collect($request->category);

            $filter = $sub_categories->filter(function ($value, $key) {
                return $value['abbr'] ==App::getLocale();
            });

            $default_category = array_values($filter->all()) [0];

            if (!$request->has('category.0.active'))
            $request->request->add(['active' => 0]);
            else
            $request->request->add(['active' => 1]);





             $filePath = "";
            if ($request->has('photo')) {

                $request->photo->store('/', 'subcategories');
                $filename = $request->photo->hashName();
                $filePath = 'images/' . 'subcategories' . '/' . $filename;
            }


          $default_category_id = SubCategory::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'parent_id' => $request->parent_id,
                'active' => $request->active,
                'category_id'=>$request->category_id,
                'photo' =>$filePath

            ]);

            $categories = $sub_categories->filter(function ($value, $key) {
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
                        'category_id'=>$request->category_id,
                        'parent_id' => $request->parent_id,
                        'photo' =>$filePath
                    ];
                     }
                   }
                SubCategory::insert($categories_arr);
                return redirect()->route('admin.subcategories')->with(['success' => 'تم الحفظ بنجاح']);
                    }
                    catch (\Exception $ex)
                    {
                        return $ex;
                        return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
                    }

    }

    public function edit( $subCat_id)
    {
        return $this->subCategory->editSubCategory($subCat_id);
    }

    public function update(RequestMainCategory $request, $subCat_id)
    {
        try {
            $sub_category = SubCategory::find($subCat_id);

            if (!$sub_category)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

            // update date

            $category = array_values($request->category) [0];

            if (!$request->has('category.0.active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);


            SubCategory::where('id', $subCat_id)
                ->update([
                    'name' => $category['name'],
                    'active' => $request->active,
                ]);

            // save image
            $filePath = "";
            if ($request->has('photo')) {

                $request->photo->store('/', 'subcategories');
                $filename = $request->photo->hashName();
                $filePath = 'images/' . 'subcategories' . '/' . $filename;
                SubCategory::where('id', $subCat_id)
                    ->update([
                        'photo' => $filePath,
                    ]);
            }




            return redirect()->route('admin.subcategories')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function destroy($id)
    {
        return $this->subCategory->deleteSubCategory($id);
    }

    public function changeStatus($id)
    {
        return $this->subCategory->changeStatusSubCategory($id);

    }

}
