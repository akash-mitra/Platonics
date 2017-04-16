<?php

namespace App;

use App\Page;
use App\LoginProvider;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'email', 'password', 'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * returns all available social login 
     * providers for the user
     */
    public function providers ($provider = null)
    {
        if (empty($provider))
            return $this->hasMany(LoginProvider::class);
        else 
            return $this->hasMany(LoginProvider::class)->where('provider', $provider);
    }



    public function pages ()
    {
        return $this->hasMany(Page::class);
    }


    public function setType ($type)
    {
        // error out if provided type is not recognizable
        if (! in_array($type, ['Admin', 'Registered', 'Author', 'Editor']))
            abort (422, 'Invalid argument');

        $this->type = $type;
        return $this->save();

    }

    // use it as $users = App\User::ofType('admin')->get();
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }


    public function getUrlAttribute()
    {
        return '/profile/user/' . $this->slug;
    }

}
