<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;


class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'payeh',
        
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projects(): belongsToMany
    {
        return $this->belongsToMany(Project::class);
    }


}
