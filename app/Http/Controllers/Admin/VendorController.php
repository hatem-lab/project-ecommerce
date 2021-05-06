<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\RequestVendor;
use DB;
use App\Notifications\vendorCreated;
use App\Repository\RepositoryServices\RepositoryInterfaceService;
use App\Repository\RepositoryServices\RepositoryService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\MainCategory;

class VendorController extends Controller
{
    protected $vendor;
    public function  __construct( RepositoryInterfaceService $vendor)
    {
        $this->vendor=$vendor;

    }
    public function index()
    {
       return $this->vendor->getVendors();
    }
    public function create()
    {
        return $this->vendor->createVendors();
    }


    public function store(RequestVendor $request)
    {

        try {

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

                $filePath = "";
                if ($request->has('logo')) {

                    $request->logo->store('/', 'vendors');
                    $filename = $request->logo->hashName();
                    $filePath = 'images/' . 'vendors' . '/' . $filename;
                }

            $vendor = Vendor::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'active' => $request->active,
                'address' => $request->address,
                'password' => $request->password,
                'logo' => $filePath,
                'category_id' => $request->category_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,

            ]);

            Notification::send($vendor, new VendorCreated($vendor));

            return redirect()->route('admin.vendors')->with(['success' => 'تم الحفظ بنجاح']);

        } catch (\Exception $ex) {
            return $ex;
            return redirect()->route('admin.vendors')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
    }
    public function edit($id)
    {
        return $this->vendor->editVendors($id);
    }
    public function update($id, RequestVendor $request)
    {

        try {

            $vendor = Vendor::Selection()->find($id);
            if (!$vendor)
                return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود او ربما يكون محذوفا ']);


            DB::beginTransaction();
            //photo
            if ($request->has('logo') ) {
                $filePath = "";
                if ($request->has('logo')) {

                    $request->logo->store('/', 'vendors');
                    $filename = $request->logo->hashName();
                    $filePath = 'images/' . 'vendors' . '/' . $filename;
                }
                Vendor::where('id', $id)
                    ->update([
                        'logo' => $filePath,
                    ]);
            }


            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

             $data = $request->except('_token', 'id', 'logo', 'password');


            if ($request->has('password') && !is_null($request->  password)) {

                $data['password'] = $request->password;
            }

            Vendor::where('id', $id)
                ->update(
                    $data
                );

            DB::commit();
            return redirect()->route('admin.vendors')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $exception) {
            return $exception;
            DB::rollback();
            return redirect()->route('admin.vendors')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }
    public function destroy($id)
    {
        return $this->vendor->deleteVendors($id);
    }
    public function changeStatus($id)
    {
        return $this->vendor->changeStatusVendors($id);
    }
}
