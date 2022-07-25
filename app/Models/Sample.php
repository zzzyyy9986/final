<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{

    protected $fillable = ["text", "parentId"];

    public function children()
    {
        return $this->hasMany(Sample::class, "parentId", "id")
            ->with("children")
            ->select(["id","parentId","text"]);
    }

}
