<?php

use App\Models\User;

return [
    //Page title
    'title' => 'Users',

    // 模型单数，用作页面『新建 $single』 will display like 'New user'
    'single' => 'user',

    //Data model, this will be used for data's CRUD
    'model' => User::class,

    //Permision of access to 'User',
    //Return false, "User" will be hidden from the Menu

    // 'permission' => function(){
    //     return Auth::user()->can('manage_users');
    // },

    /**
     * we need to write the above function in app/helpers.php file so that we can do config caching
     */
    'permission' => 'manageUsers', // 'manageUsers' function we have written in /app/helpers.php file

    //Build the data table, set each column you want to display in table
    'columns' => [
        //The following columns refer to User's model's each property
        //We can customize its display name and output
        'id',

        'avatar' => [
            //Defaultly use the column name, but we can set it here
            'title' => 'Avatar',

            //Defaultly output the value directly, but we can set it here

            // 'output' => function($avatar, $model){
            //     return empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" width="40">';
            // },

            'output' => 'administratorOutputUsersAvatar', //This function is written in /app/helpers.php file

            //If allowed to sort data
            'sortable' => false,
        ],

/**
        'name' => [
            'title' => 'Username',
            'sortable' => false,
            'output' => function ($name, $model) {
                return '<a href="' . url('/users/' . $model->id) . '" target=_blank>' . $name . '</a>';
                //return '<a href="/users/'.$model->id.'" target=_blank>'.$name.'</a>';
            },
        ],
*/
        'name' => [
            'title' => 'Username',
            'sortable' => false,
            'output' => 'administratorOutputUsersName', //function is written in /app/helpers.php file
        ],

        'email' => [
            'title' => 'Email',
        ],

        //This one is not the model's property, this is the last column in table for edit/delete button
        'operation' => [
            'title' => 'Manage operations',
            'sortable' => false,
        ],
    ],

    //Model setting field
    'edit_fields' => [
        'name' => [
            'title' => 'Username',
        ],

        'email' => [
            'title' => 'Email',
        ],

        'password' => [
            'title' => 'Password',
            'type' => 'password', //tell form input type
        ],

        'avatar' => [
            'title' => 'User avatar',
            'type' => 'image', //tell form using '<img'> tag. Default is input
            //Image upload path
            'location' => public_path() . '/upload/images/avatars/',
        ],

        'roles' => [
            'title' => 'User roles',
            'type' => 'relationship', //tell the system, this is a relationship model
            'name_field' => 'name',//Model's name column will be displayed
        ],
    ],

    //Data filter setting
    'filters' => [
        'id' => [
            'title' => 'User ID',//table filter item's displaying name
        ],

        'name' => [
            'title' => 'Username',
        ],

        'email' => [
            'title' => 'Email',
        ],
    ],
];
