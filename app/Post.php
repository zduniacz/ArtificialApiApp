<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use Sortable;
    protected $fillable = ['title', 'body', 'category_id', 'user_id'];
    protected $sortable = ['id', 'created_at', 'updated_at'];

    // #### relationships ####
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->sortable(['id' => 'desc']);
    }
}
