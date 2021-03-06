<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Model class for the User.
 * NOTE: this might need to be update to polymorphic as more user types get introduced.
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'username', 'email', 'password', 'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**********************************************************************************
     * Guides
     **********************************************************************************/

    public function guide() {
        return $this->hasOne('App\Models\Guide');
    }

    /**********************************************************************************
     * Social Media
     **********************************************************************************/

    public function socialmedia() {
        return $this->hasOne('App\Models\SocialMedia');
    }

    /**********************************************************************************
     * Videos
     **********************************************************************************/

    public function videos() {
        return $this->hasMany('App\Models\Video');
    }

    /**********************************************************************************
     * Log Attachments
     **********************************************************************************/

    public function log_attachments() {
        return $this->hasMany('App\Models\LogAttachment');
    }

    /**********************************************************************************
     * Roles
     **********************************************************************************/


    /**  TODO implement better roles.   Current role sample from
     * https://medium.com/@ezp127/laravel-5-4-native-user-authentication-role-authorization-3dbae4049c8a */

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param string|array $roles
     */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized.');
    }
    /**
     * Check multiple roles
     * @param array $roles
     */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    /**
     * Check one role
     * @param string $role
     */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }
}
