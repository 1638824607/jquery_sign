<?php

namespace App\Admin;

class BookRecommend extends BaseModel
{
    protected $table = "book_recommend";

    protected $guarded = [
        ''
    ];

    /**
     * 获取一周的推荐小说
     * @param $startDay
     * @param $endDay
     * @return array
     * @author shenruxiang
     * @date 2018/11/23 20:28
     */
    public static function getBookRecommendByStartAndEndDay($startDay, $endDay)
    {
        $startDay = empty($startDay) ? '' : trim($startDay);
        $endDay   = empty($endDay) ? '' : trim($endDay);

        if(empty($startDay) || empty($endDay)) {
            return [];
        }

        $bookRecommendList = BookRecommend::where('start_day', $startDay)->where('end_day', $endDay)->get();

        if(empty($bookRecommendList)) {
            return [];
        }

        return $bookRecommendList->toArray();
    }

    /**
     * 得到推荐列表
     * @return array
     * @author shenruxiang
     * @date 2018/11/23 20:29
     */
    public static function getBookRecommendList()
    {
        $bookRecommendList = BookRecommend::orderBy('id', 'DESC')->groupBy('start_day')->get();

        if(empty($bookRecommendList)) {
            return [];
        }

        return $bookRecommendList->toArray();
    }


}
