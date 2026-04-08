<?php
namespace App\Traits;
use App\Models\Uactivity;

trait Useractivity
{
    public function storeUseractivity($actmodel_id, $actoperation_id, $userid, $rowid, $description)
    {
        $uactivity = new Uactivity;
        $uactivity->user_id = $userid;
        $uactivity->actmodel_id = $actmodel_id;
        $uactivity->actoperation_id = $actoperation_id;
        $uactivity->rowid = $rowid;
        $uactivity->description = $description;
        $uactivity->save();
        
        return $uactivity;
    }
    
    
}