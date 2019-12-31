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

