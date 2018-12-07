<?php

namespace App\Admin;

use Illuminate\Support\Facades\DB;

class Book extends BaseModel
{
    protected $table = "books";

    protected $guarded = [
        'collect_num'
    ];

    /**
     * 根据book_id获取单条数据
     * @param $bookId
     * @return array
     * @author shenruxiang
     * @date 2018/11/23 16:20
     */
    public static function getBookRowById($bookId)
    {
        $bookId = empty($bookId) ? 0 : intval($bookId);

        if(empty($bookId)) {
            return [];
        }

        $bookRow = Book::where('id', $bookId)->where('status', 2)->first();

        if(empty($bookRow)) {
            return [];
        }

        return $bookRow->toArray();
    }

    /**
     * 批量获取小说
     * @param $bookIdArr
     * @return array
     * @author shenruxiang
     * @date 2018/11/23 18:58
     */
    public static function getBookListByIdArr($bookIdArr)
    {
        $bookIdArr = empty($bookIdArr) && !is_array($bookIdArr) ? '' : $bookIdArr;

        if(empty($bookIdArr)) {
            return [];
        }

        $bookList = Book::whereIn('id', $bookIdArr)->where('status', 2)->get();

        if(empty($bookList)) {
            return [];
        }

        return $bookList->toArray();
    }

    /**
     * 猜你喜欢 根据type获取小说列表
     * @param $bookType
     * @return array
     * @author shenruxiang
     * @date 2018/11/23 16:39
     */
    public static function getBookListListByType($bookType)
    {
        $bookType = empty($bookType) ? 0 : intval($bookType);

        if(empty($bookType)) {
            return [];
        }

        $bookLikeList = Book::where('status', 2)->where('type', $bookType)->orderBy(DB::raw('RAND()'))
            ->take(10)->get();

        if(empty($bookLikeList)) {
            return [];
        }

        return $bookLikeList->toArray();
    }
}
