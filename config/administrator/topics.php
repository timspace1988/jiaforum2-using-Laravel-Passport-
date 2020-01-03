<?php

use App\Models\Topic;

return [
    'title' => 'Topics',
    'single' => 'topic',
    'model' => Topic::class,

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title' => 'Topic',
            'sortable' => false,
            'output' => function ($value, $model){
                return '<div style="max-width:260px">' . model_link($value, $model) . '</div>';
            },
        ],
        'user' => [
            'title' => 'Author',
            'sortable' => false,
            'output' => function ($value, $model){
                $avatar = $model->user->avatar;
                $value = empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" style="height:22px;width:22px"> ' . $model->user->name;
                return model_link($value, $model->user);
            },
        ],
        'category' => [
            'title' => 'Category',
            'sortable' => false,
            'output' => function ($value, $model){
                return model_admin_link(e($model->category->name), $model->category);
            },
        ],
        'reply_count' => [
            'title' => 'Replies',
        ],
        'operation' => [
            'title' => 'Manage operations',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title' => 'Topic',
        ],
        'user' => [
            'title' => 'User',
            'type' => 'relationship',
            'name_field' => 'name',

            // 自动补全，对于大数据量的对应关系，推荐开启自动补全，
            // 可防止一次性加载对系统造成负担
            'autocomplete' => true,
            //Drop list will not display anything until you type some characters, then it will search it

            //the search columns for autocomplete
            'search_fields' => ["CONCAT(id, ' ', name)"],
            //javascript code: conact() join twor or more strings
            //e.g. it will search '1 JIA', '2 James Bond'
            //That means, you can type ID or name to search the user

            //Sort the the items by id if you got mutiple searching results
            'options_sort_field' => 'id',
        ],
        'category' => [
            'title' => 'Category',
            'type' => 'relationship',
            'name_field' => 'name',
            'search_fields' => ["CONACT(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'reply_count' => [
            'title' => 'Replies',
        ],
        'view_count' => [
            'title' => 'Views',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'Topic ID',
        ],
        'user' => [
            'title' => 'User',
            'type' => 'relationship',
            'name_field' => 'name',
            'autocomplete' => true,
            'search_fields' => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'category' => [
            'title' => 'Category',
            'type' => 'relationship',
            'name_field' => 'name',
            //'autocomplete' => true,
            'search_fields' => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
    ],
    'rules' => [
        'title' => 'required',
    ],
    'messages' => [
        'title.required' => 'Please type the topic title',
    ],

];
