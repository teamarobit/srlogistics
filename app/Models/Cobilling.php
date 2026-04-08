<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cobilling extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'contact_id',
        'address',
        'address1',
        'address2',
        'country_id',
        'state_id',
        'city_id',
        'zipcode',
        'add_info',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updatedby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function deletedby()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
