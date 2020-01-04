<?php

use App\Models\Link;

return [
    'title' => 'Recommended resources',
    'single' => 'link',

    'model' => link::class,

    //Check visit permission
    'permission' => function(){
        //Only founder can manage the links
        return Auth::user()->hasRole('Founder');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title' => 'Resource name',
            'sortable' => false,
        ],
        'link' => [
            'title' => 'Link of resource',
            'sortable' => false,
        ],
        'operation' => [
            'title' => 'Manage operation',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title' => 'Resource name',
        ],
        'link' => [
            'title' => 'Link of resource',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title' => 'Resource name',
        ],
    ],
];
