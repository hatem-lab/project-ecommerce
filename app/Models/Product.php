<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table='products';
    protected $fillable = [
        'name', 'description', 'inCard','category_id','subcategory_id','photo','purchase_price','sale_price','stock','active'
    ];
    public function category()
    {
        return  $this->belongsTo('App\Models\MainCategory','category_id');
    }

    public function subcategory()
    {
        return  $this->belongsTo('App\Models\SubCategory','subcategory_id');
    }
    public function scopeSelection($query)
    {
        return $query->select('id','name','active', 'description', 'category_id','subcategory_id','photo','purchase_price','sale_price','stock');
    }
    public function getActive()
    {
        return $this->active == 1 ? 'مفعل' : 'غير مفعل';

    }
    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";

    }
    public function scopeDefaultCategory($query){
        return  $query -> where('translation_of',0);
    }
    public function translation()
    {
        return $this->hasMany(self::class, 'translation_of');
    }

}
