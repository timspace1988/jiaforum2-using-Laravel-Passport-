<?php

use Spatie\Permission\Models\Permission;

return [
    'title' => 'Permisions',
    'single' => 'permission',
    'model' => Permission::class,

    'permission' => function(){
        return Auth::user()->can('manage_users');
    },

    /**
    The seperate permission control for CRUD action of Permission model,
    return false means having not right to do it
    */
    'action_permissions' => [
        //Display New permission button
        'create' => function($model){
            return true;
        },

        //Allowed to update (edit field save button)
        'update' => function($model){
            return true;
        },

        //Don't allow to delete (delete button)
        'delete' => function($model){
            return false;
        },

        //Allowed to view (right side display panel)
        'view' => function ($model){
            return true;
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => 'Permission name',
        ],
        'operation' => [
            'title' => 'Manage operations',
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'name' => [
            'title' => 'Permission name (be careful to change it)',

            //hint message for this form input
            'hint' => 'Changing permission name will affect the call of some code, be careful.',
        ],
        'roles' => [
            'type' => 'relationship',
            'title' => 'Roles',
            'name_field' => 'name',
        ],
    ],

    'filters' => [
        'name' => [
            'title' => 'Permission name',
        ],
    ],


];
