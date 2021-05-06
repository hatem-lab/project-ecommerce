<?php
namespace App\Repository\RepositoryServices;

interface RepositoryInterfaceService
{
    /* for lannguages  */
    public function getLanguage();
    public function createLanguage();
    public function storeLanguage(array $data);
    public function editLanguage($id);
    public function updateLanguage($id,array $data);
    public function deleteLanguage($id);

    /* for MainCategories  */

    public function getMainCategory();
    public function createMainCategory();
    public function storeMainCategory(array $data);
    public function editMainCategory($id);
    public function updateMainCategory($id,array $data);
    public function deleteMainCategory($id);
    public function changeStatusMainCategory($id);

        /* for SubCategories  */

    public function getSubCategory();
    public function createSubCategory();
    public function storeSubCategory(array $data);
    public function editSubCategory($id);
    public function updateSubCategory($id,array $data);
    public function deleteSubCategory($id);
    public function changeStatusSubCategory($id);

        /* for Vendors  */

    public function getVendors();
    public function createVendors();
    public function storeVendors(array $data);
    public function editVendors($id);
    public function updateVendors($id,array $data);
    public function deleteVendors($id);
    public function changeStatusVendors($id);

}
