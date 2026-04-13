<?php

namespace App\Models;

use App\Models\Traits\UsedFunctions;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use UsedFunctions;

    protected $guarded = [];
    public $timestamps = false;
}
