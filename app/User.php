<?php

namespace App;

use App\Page;
use App\Comment;
use App\LoginProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


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


    public function comments ()
    {
        return $this->hasMany(Comment::class);
    }


    /**
     * This function provides a list of user articles with
     * article title, id, category slug and publish date.
     * This is very similar to pages() method, but unlike 
     * pages() this does not return article body, which
     * means volume of return data is much lesser and
     * the results are easily cachable.
     */
    public function articles ()
    {
        $articles = DB::table('pages')
                    ->leftjoin('categories', 'pages.category_id', 'categories.id')
                    ->where('user_id', $this->id)
                    ->select('pages.id','pages.title', 'pages.created_at', 'categories.slug')
                    ->get();
        return $articles;
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
        // return '/profile/user/' . $this->slug;
        return route('user', $this->slug);
    }


    public function assets()
    {
        return $this->hasMany(Image::class);
    }


    public static function permittedAttributes ()
    {
        $authUser = Auth::user();
        
        if ($authUser->type === 'Registered') 
        {
            // no email, no type, no last_updated
            return ['id', 'name', 'avatar', 'created_at', 'slug'];
        }

        if ($authUser->type === 'Author') 
        {
            // no email
            return ['id', 'name', 'avatar', 'type', 'created_at', 'updated_at', 'slug'];
        }

        if (in_array($authUser->type, ['Admin', 'Editor'])) 
        {
            return ['id', 'name', 'avatar', 'email', 'type', 'created_at', 'updated_at', 'slug'];
        }

        return ['id', 'slug'];
    }

}
