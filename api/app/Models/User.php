<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    const ROLE_CLIENT = 'client';
    const ROLE_ADMIN = 'admin';

    const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_CLIENT
    ];

    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'api_token_expire_date', 'company_id', 'role'
    ];

    protected $hidden = [
        'password', 'api_token', 'api_token_expire_date',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'user_projects');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function hasTokenExpired()
    {
        try {
            $expireDate = new Carbon($this->api_token_expire_date);
            $today = new Carbon();
        } catch (\Exception $e) {
            return true;
        }

        if ($expireDate->lt($today)) {
            return true;
        }

        return false;
    }

    public function regenerateToken()
    {
        $this->api_token = Str::random(60);
        $this->api_token_expire_date = (new \Carbon\Carbon())->addDays(1);
    }
}
