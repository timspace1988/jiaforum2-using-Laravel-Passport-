<?php

function route_class(){
    return str_replace('.', '-', Route::currentRouteName());
}

//return 'active' for currently selected category
function category_nav_active($category_id){
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

//create excerpt using given content
function make_excerpt($value, $length = 200){
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return Str::limit($excerpt, $length);
}


if(!function_exists('manageContents')){
    function manageContents(){
        return Auth::check() && Auth::user()->can('manage_contents');
    }
}

if(!function_exists('manageUsers')){
    function manageUsers(){
        return Auth::check() && Auth::user()->can('manage_users');
    }
}

if(!function_exists('administratorOutputUsersAvatar')){
    function administratorOutputUsersAvatar($avatar, $model){
        return empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" width="40">';
    }
}

if(!function_exists('administratorOutputUsersName')){
    function administratorOutputUsersName($name, $model) {
        return '<a href="' . url('/users/' . $model->id) . '" target=_blank>' . $name . '</a>';
        //return '<a href="/users/'.$model->id.'" target=_blank>'.$name.'</a>';
    }
}

function model_admin_link($title, $model){
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = ''){
    $model_name = model_plural_name($model);//变复数

    //Initialize the prefix
    $prefix = $prefix ? "/$prefix/" : '/';

    //Make full url by using site's url
    $url = config('app.url') . $prefix . $model_name. '/' . $model->id;

    //Return a full HTML <a> tag
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';

    //return $title;
}

function model_plural_name($model){
    //Get the full class name by using a model instance
    $full_class_name = get_class($model);//e.g. App\Models\User

    //Get base name of the class e.g. App\Models\User -> User
    $class_name = class_basename($full_class_name);

    //Snake name e.g. User->user, FooBar -> foo-bar
    $snake_case_name = Str::snake($class_name);

    //Get the plural form
    return Str::plural($snake_case_name);
}

//Get database config info based on environment
function get_db_config(){
    if(getenv('IS_IN_HEROKU')){
        $url = parse_url(getenv('DATABASE_URL'));

        return $db_config = [
            'connection' => 'pgsql',
            'host' => $url['host'],
            'database' => substr($url['path'], 1),
            'username' => $url['user'],
            'password' => $url['pass'],
        ];
    }else{
        return $db_config = [
            'connection' => env('DB_CONNECTION', 'mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DATABASE_USERNAME', 'forge'),
            'password' => env('DATABASE_PASSWORD', ''),
        ];
    }
}

//Get redis config info
function get_redis_config(){
    if(getenv('IS_IN_HEROKU')){
        $url = parse_url(getenv('REDIS_URL'));

        return [
            'url' => getenv('REDIS_URL'),
            'host' => $url['host'],
            'password' => $url['pass'],
            'port' => $url['port'],
            // 'database' => $url['user'],
            // 'database_cache' => $url['user'],
        ];
    }else{
        return [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            // 'database' => env('REDIS_DB', 0),
            // 'database_cache' => env('REDIS_DB', 1),
        ];
    }
}
