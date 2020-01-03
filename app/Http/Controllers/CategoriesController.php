<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
use App\Models\User;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic, User $user){
        //Get topics with selected category, and display them with 20 on each page
        $topics = $topic->withOrder($request->order)->with('user', 'category')->where('category_id', $category->id)->paginate(20);

        //Get the list of active users
        $active_users = $user->getActiveUsers();

        return view('topics.index', compact('topics', 'category', 'active_users'));
    }
}
