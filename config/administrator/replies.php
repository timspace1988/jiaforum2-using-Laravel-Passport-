<?php

use App\Models\Reply;

return [
    'title' => 'Replies',
    'single' => 'reply',
    'model' => Reply::class,

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'content' => [
            'title' => 'Content',
            'sortable' => false,
            'output' => function($value, $model){
                return '<div style="max-width:220px">' . $value . '</div>';
            },
        ],
        'user' => [
            'title' => 'Author',
            'sortable' => false,
            'output' => function($value, $model) {
                $avatar = $model->user->avatar;
                $value = empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" style="height:22px;width:22px"> ' . $model->user->name;
                    return  model_link($value, $model->user);
            },
        ],
        /**
         * 默认情况下，Administrator 会对所有的输出内容进行 htmlspecialchars() 过滤，以此来防范 XSS 攻击。然而当你在『数据表格』中使用 output 选项输出 HTML 时，Administrator 将无法保护你：

         需要谨记的一点 ——『永远不要相信用户能够修改的数据』，output 选项接受的两个参数里，$value          的数据是被过滤过的，可以安全使用。其他的用户数据，输出时请使用 Laravel 自带的 e() 函数对其做转义处理，如下面的例子：model_admin_link(e($model->topic->title), $model->topic)
         But for above one model_link($value, $model->user), no need to do it
         */
        'topic' => [
            'title' => 'Topic',
            'sortable' => false,
            'output' => function($value, $model){
                return '<div style="max-width:260px">' . model_admin_link(e($model->topic->title), $model->topic) . '</div>';
            },
        ],
        'operation' => [
            'title' => 'Manage operations',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'user' => [
            'title' => 'User',
            'type' => 'relationship',
            'name_field' => 'name',
            'autocomplete' => true,
            'search_fields' => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'topic' => [
            'title' => 'Topic',
            'type' => 'relationship',
            'name_field' => 'title',
            'autocomplete' => true,
            'search_fields' => array("CONCAT(id, ' ', title)"),
            'options_sort_field' => 'id',
        ],
        'content' => [
            'title' => 'Reply content',
            'type' => 'textarea',
        ],
    ],
    'filters' => [
        'user' => [
            'title' => 'User',
            'type' => 'relationship',
            'name_field' => 'name',
            'autocomplete' => true,
            'search_fields' => array("CONCAT(id, ' ', title)"),
            'options_sort_field' => 'id',
        ],
        'content' => [
            'title' => 'Reply content',
        ],
    ],
    'rules' => [
        'content' => 'required',
    ],
    'messages' => [
        'content.required' => 'Please type reply content',
    ],
];
