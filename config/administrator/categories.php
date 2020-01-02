<?php

use App\Models\Category;

return [
    'title' => 'Categories',
    'single' => 'category',
    'model' => Category::class,

    //CRUD permission
    'action_permissions' => [
        'delete' => function (){
            //Only founder can delete a category
            return Auth::user()->hasRole('Founder');
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => 'Category name',
            'sortable' => false,
        ],
        'description' =>[
            'title' => 'Description',
            'sortable' => false,
        ],
        'operation' => [
            'title' => 'Manage operation',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name' => [
            'title' => 'Category name',
        ],
        'description' => [
            'title' => 'Description',
            'type' => 'textarea',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'Category ID',
        ],
        'name' => [
            'title' => 'Category name',
        ],
        'description' => [
            'title' => 'Description',
        ],
    ],
    'rules' => [
        'name' => 'required|min:1|unique:categories',
    ],
    'messages' => [
        'name.unique' => 'This category has been existing in databse, please choose another name.',
        'name.required' => 'Minimun length is 1 character.'
    ],
];
