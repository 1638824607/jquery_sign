<?php

namespace App\Admin;

use Illuminate\Support\Facades\DB;

class MongoChapter
{
    protected $collection = 'chapter';
    protected $connection = 'mongodb';
    public static function test()
    {
        return  DB::connection('mongodb')->collection('chapter')->get();
//        $users = DB::connection('mongodb')->collection('chapter')->get();
//        dd($users);
    }
}
