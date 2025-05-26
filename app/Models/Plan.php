<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $guarded = ['created_at', 'updated_at', 'id'];

    public function payments() {
        return $this->hasMany(Payment::class);
    }

}
