<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'start_date', 'end_date', 'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_projects');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function hasUser(User $user): bool
    {
        return $this->users->where('id', '=', $user->id)->first() !== null;
    }
}
