<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\Bulkable;
use App\Models\Traits\Toggleable;
use Illuminate\Support\Facades\Hash;
use App\Models\Contracts\BulkActions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User.
 *
 * @property int                                                                                                       $id
 * @property string                                                                                                    $name
 * @property string                                                                                                    $email
 * @property string|null                                                                                               $email_verified_at
 * @property string                                                                                                    $password
 * @property string|null                                                                                               $remember_token
 * @property bool                                                                                                      $active
 * @property array|null                                                                                                $roles
 * @property \Illuminate\Support\Carbon|null                                                                           $last_access_at
 * @property \Illuminate\Support\Carbon|null                                                                           $created_at
 * @property \Illuminate\Support\Carbon|null                                                                           $updated_at
 * @property bool                                                                                                      $is_owner
 * @property bool                                                                                                      $is_admin
 * @property \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property int|null                                                                                                  $notifications_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($role)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements BulkActions
{
    use Notifiable;
    use Bulkable;
    use Toggleable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'roles',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'active'         => 'boolean',
        'roles'          => 'array',
        'last_access_at' => 'datetime',
    ];

    public $toggleables = [
        'active',
    ];

    protected $appends = [
        'is_owner',
        'is_admin',
    ];

    public function getIsOwnerAttribute()
    {
        return 1 === $this->id;
    }

    public function getIsAdminAttribute()
    {
        return $this->is_owner || $this->hasRole('admin');
    }

    public function hasRole($role)
    {
        return \in_array($role, $this->roles ?? [], true);
    }

    public function scopeRole(Builder $query, $role)
    {
        return $query->whereJsonContains('roles', $role);
    }

    /**
     * @param bool $resetPassword
     */
    public function saveWithPassword(bool $resetPassword = false)
    {
        if (! $this->exists || $resetPassword) {
            $this->password = Hash::make(Str::random());
        }

        $this->save();

        if ($resetPassword) {
            $this->sendPasswordResetNotification(
                app('auth.password.broker')->createToken($this)
            );
        }
    }

    public static function bulkActions()
    {
        return [
            'enable' => [
                'active' => true,
            ],
            'disable' => [
                'active' => false,
            ],
        ];
    }

    public function __toString()
    {
        return $this->name;
    }
}
