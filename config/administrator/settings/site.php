<?php

return [
    'title' => 'Site settings',

    //Permission check
    'permission' => function(){
        //Only founder can access site setting page
        return Auth::user()->hasRole('Founder');
    },

    //Site configuration form, these data will be saved into storage/administrator_settings/site.json
    'edit_fields' => [
        'site_name' => [
            'title' => 'Site name',
            'type' => 'text',//input type
            'limit' => 50, //length limit
        ],
        'contact_email' => [
            'title' => 'Contact email',
            'type' => 'text',
            'limit' => 50,
        ],
        'seo_description' => [
            'title' => 'SEO - Description',
            'type' => 'textarea',
            'limit' => 250,
        ],
        'seo_keyword' => [
            'title' => 'SEO - Keywords',
            'type' => 'textarea',
            'limit' => 250,
        ],
    ],

    //Validation rules
    'rules' => [
        'site_name' => 'required|max:50',
        'contact_email' => 'email',
    ],

    'messages' => [
        'site_name.required' => 'Please type your site name.',
        'contact_email.email' => 'Please type contact email in correct format.',
    ],

    //数据即将保持的触发的钩子，可以对用户提交的数据做修改
    //& means we pass the reference(address) of variable here instead of value
    'before_save' => function(&$data){
        //If the site name doesn't have a posfix , we add a postfix to it
        if(strpos($data['site_name'], 'Powered by JiaForum') === false){
            $data['site_name'] .=' - Powered by JiaForum';
        }
    },

    //You can add multiple actions here, They will be displayed in the "Other operations" at bottom
    'actions' => [
        //Clear the cache
        'clear_cache' => [
            'title' => 'Clear the system cache.',

            //The status reminder messages
            'messages' => [
                'active' => 'Clearing system cache...',
                'success' => 'Cache has been cleared.',
                'error' => 'Error occurs during cache clearing.',
            ],

            //The codes gonna be executed, you can modify the $data to change site configurations
            //But here, clearing the cache only needs 'artisan calls'
            'action' => function(&$data){
                \Artisan::call('cache:clear');
                return true;
            }
        ],
    ],
];
