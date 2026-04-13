<?php

namespace App\Models;

use App\Models\Traits\UsedFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Page extends Model
{
    use UsedFunctions;

    protected $guarded = [];
    public $timestamps = false;
}
