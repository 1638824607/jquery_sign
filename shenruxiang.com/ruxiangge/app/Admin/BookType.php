<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    protected $table = "book_types";

    protected $fillable = [
        'name', 'status', 'sort'
    ];

    public $timestamps = false;

}
