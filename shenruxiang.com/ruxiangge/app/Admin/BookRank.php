<?php

namespace App\Admin;

class BookRank extends BaseModel
{
    protected $table = "book_ranks";

    protected $guarded = [
        ''
    ];

    public static function getBookRankListByRankName($rankName)
    {
        $rankName = empty($rankName) ? '' : trim($rankName);

        if(empty($rankName)) {
            return [];
        }

        $bookRankRow = BookRank::where('rank_name', $rankName)->first();

        if(empty($bookRankRow)) {
            return [];
        }

        return $bookRankRow->toArray();
    }

}
