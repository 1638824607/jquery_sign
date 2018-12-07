<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class BookReader extends Model
{
    protected $table = "book_readers";

    protected $fillable = [
        'name','status'
    ];

    public $timestamps = false;

}
