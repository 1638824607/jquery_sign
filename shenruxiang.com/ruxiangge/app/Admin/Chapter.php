<?php

namespace App\Admin;

class Chapter extends BaseModel
{
    protected $table = "chapters";

    protected $guarded = [
        ''
    ];

    /**
     * 根据chapter_id获取章节信息
     * @param $chapterId
     * @return array
     * @author shenruxiang
     * @date 2018/11/23 17:09
     */
    public static function getChapterRowById($chapterId)
    {
        $chapterId = empty($chapterId) ? 0 : intval($chapterId);

        if(empty($chapterId)) {
            return [];
        }

        $chapterRow = Chapter::where('id', $chapterId)->where('status', 1)->first();

        if(empty($chapterRow)) {
            return [];
        }

        return $chapterRow->toArray();
    }

    /**
     * 根据book_id获取小说末章
     * @param $bookId
     * @return array
     * @author shenruxiang
     * @date 2018/11/23 16:23
     */
    public static function getLastChapterRowById($bookId)
    {
        $bookId = empty($bookId) ? 0 : intval($bookId);

        if(empty($bookId)) {
            return [];
        }

        $lastChapterRow = Chapter::where('book_id', $bookId)->where('status', 1)->orderBy('sort', 'DESC')->first();

        if(empty($lastChapterRow)) {
            return [];
        }

        return $lastChapterRow->toArray();
    }

    /**
     * 根据book_id获取小说首章
     * @param $bookId
     * @return array
     * @author shenruxiang
     * @date 2018/11/23 17:07
     */
    public static function getFirstChapterRowById($bookId)
    {
        $bookId = empty($bookId) ? 0 : intval($bookId);

        if(empty($bookId)) {
            return [];
        }

        $firstChapterRow = Chapter::where('book_id', $bookId)->where('status', 1)->orderBy('sort', 'ASC')->first();

        if(empty($firstChapterRow)) {
            return [];
        }

        return $firstChapterRow->toArray();
    }

    /**
     * 根据sort获取章节信息
     * @param $bookId
     * @param $sort
     * @return array
     * @author shenruxiang
     * @date 2018/11/23 18:03
     */
    public static function getChapterRowByBookIdAndSort($bookId, $sort)
    {
        $bookId = empty($bookId) ? 0 : intval($bookId);
        $sort   = empty($sort) ? 0 : intval($sort);

        if(empty($bookId) || empty($sort)) {
            return [];
        }

        $chapterRow = Chapter::where('sort', $sort)->where('book_id', $bookId)->where('status', 1)->first();

        if(empty($chapterRow)) {
            return [];
        }

        return $chapterRow->toArray();
    }

}
