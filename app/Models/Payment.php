<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    protected $guarded = ['created_at', 'updated_at', 'id'];


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
