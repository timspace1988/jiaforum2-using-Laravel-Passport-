<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * We don't create timestamps(created_at and updated_at) in database's categories table,
     * So, we need to tell laravel not to maintain created_at and updated_at when we create * and update the Category instance
     */
    public timestamps = false;

    protected $fillable = ['name', 'description'];
}
