<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tyre extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function tyrevendor()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }
    
    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
    
    public function images(){
        return $this->morphMany(Media::class, 'mediable')->where('type', 'Image');
    }

    /**
     * Tyre photos: standalone images (not part of a document bundle).
     * Used on vehicle details V2 tyre card modal — shows raw upload images with date/time.
     * Filters: type = 'Image' AND mediadocument_id IS NULL.
     */
    public function tyrePhotos(){
        return $this->morphMany(Media::class, 'mediable')
                    ->where('type', 'Image')
                    ->whereNull('mediadocument_id');
    }
    
    public function documents(){
        return $this->morphMany(Media::class, 'mediable')->where('type', 'Document');
    }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function maintenanceSchedules()
    {
        return $this->hasMany(TyreMaintenanceSchedule::class, 'tyre_id');
    }

    // public function updatedBy()
    // {
    //     return $this->belongsTo(User::class, 'updated_by');
    // }
    
    // public function deletedBy()
    // {
    //     return $this->belongsTo(User::class, 'deleted_by');
    // }
    
    
    
}