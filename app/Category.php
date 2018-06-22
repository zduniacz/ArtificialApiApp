<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;
use Kyslik\ColumnSortable\Sortable;


class Category extends Model
{
    use Sortable;
    protected $fillable =['title'];
    protected $sortable = ['title'];

    // #### relationships
    public function posts()
    {
        return $this->hasMany(Post::class)->sortable(['id' => 'desc']);
    }
}
