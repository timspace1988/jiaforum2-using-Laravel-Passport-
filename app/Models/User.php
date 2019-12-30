<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;

class User extends Authenticatable implements MustVerifyEmailContract
{

    use MustVerifyEmailTrait;
    use Notifiable{
        //Give a alias name to notify() in Notifiable trait, because we will call it in our rewrited notify()
        notify as protected laravelNotify;
    }

    //Rewrite notify function in trait Notifiable
    public function notify($instance){
        //If the replied topic owner is the current user, we don't need to notify ourselves
        if($this->id == Auth::id()){
            return;
        }

        //Only send the database type notification, check if the $instance has this type
        if(method_exists($instance, 'toDatabase')){
            //user's unread notificaton + 1
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'introduction'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    //Check if this user is the owner of the given model instance
    public function isAuthorOf($model){
        return $this->id == $model->user_id;
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }
}
