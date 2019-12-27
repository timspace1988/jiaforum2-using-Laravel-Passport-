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

