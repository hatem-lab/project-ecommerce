<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Vendor extends Model
{
    use Notifiable;
    protected $table = 'vendors';

    protected $fillable = [
        'latitude', 'longitude', 'name', 'mobile',  'address','password', 'email', 'logo', 'category_id', 'active'
    ];
    protected $hidden = ['category_id'];


    public function scopeActive($query)
    {

        return $query->where('active', 1);
    }

    public function getLogoAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";

    }


    public function scopeSelection($query)
    {
        return $query->select('latitude', 'longitude','id', 'category_id', 'active', 'password','name', 'address', 'email', 'logo', 'mobile');
    }


    public function category()
    {

        return $this->belongsTo('App\Models\MainCategory', 'category_id', 'id');
    }

    public function getActive()
    {
        return $this->active == 1 ? 'مفعل' : 'غير مفعل';

    }

}
