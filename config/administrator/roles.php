<?php

use Spatie\Permission\Models\Role;

return [
    'title' => 'Roles',
    'single' => 'role', //will displayed as 'New role'
    'model' => Role::class,

    'permission' => function(){
        return Auth::user()->can('manage_users');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => 'Role',
        ],
        'permissions' => [
            'title' => 'Permissions',
            'output' => function($value, $model){
                /**
                load() is similar to with(), which will also retrive the related mdoel( here permissions)
                in Spatie\Permission\Models\Role, it has already set the relationship between Role and    Permission as one to Many (belongsToMany), and set the relationship table as role_has_permissions
                */
                $model->load('permissions');
                $result = [];
                foreach ($model->permissions as $permission) {
                    $result[] = $permission->name;
                }

                return empty($result) ? 'N/A' : implode('|', $result);
            },
            'sortable' => false,
        ],
        'operation' => [
            'title' => 'Manage operations',
            'output' => function($value, $model){
                return $value;
            },//This looks like a default output, deleting it doesn't change anything

            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'name' => [
            'title' => 'Role name',
        ],
        'permissions' => [
            'type' => 'relationship',
            'title' => 'Permission',
            'name_field' => 'name',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => 'Role name',
        ],
    ],

    //Validation rules for creating new or edit
    'rules' => [
        'name' => 'required|max:15|unique:roles,name',
    ],

    //Error message when validation failed
    'messages' => [
        'name.required' => 'Role name cannot be empty',
        'name.unique' => 'Role name has been existing',
    ],
];
