<?php

namespace App\Http\Controllers\Admin;
use App\Repository\RepositoryServices\RepositoryService;
use App\Http\Requests\RequesrLanguage;
use App\Repository\RepositoryServices\RepositoryInterfaceService;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Notifications\VendorCreated;
use Illuminate\Http\Request;
use App\Http\Requests\RequestLanguage;

class LanguageController extends Controller
{
    protected $language;
    public function  __construct( RepositoryInterfaceService $language)
    {
        $this->language=$language;

    }


    public function index()
    {
        return  $this->language->getLanguage();
    }


    public function create()
    {
        return  $this->language->createLanguage();
    }


    public function store(RequesrLanguage $request)
    {
        return  $this->language->storeLanguage($request->all());
    }



    public function edit($id)
    {
        return  $this->language->editLanguage($id);
    }


    public function update($id,RequesrLanguage $request)
    {
        if (!$request->has('active'))
        $request->request->add(['active' => 0]);
        else
        $request->request->add(['active' => 1]);

        return  $this->language->updateLanguage($id,$request->all());
    }


    public function destroy($id)
    {
        return  $this->language->deleteLanguage($id);
    }
}
