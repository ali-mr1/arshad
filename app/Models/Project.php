<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'metraj',
        'group',
        'user_id',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
