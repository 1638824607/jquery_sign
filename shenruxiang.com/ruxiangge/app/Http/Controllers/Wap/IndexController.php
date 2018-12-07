<?php

namespace App\Http\Controllers\Wap;

use App\Admin\Book;
use App\Admin\BookRank;
use App\Admin\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends BaseController
{
    /**
     * 前台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/9 09:37
     */
    public function index(Request $request)
    {
        $indexPage = $request->session()->get('wap_index_page', function () use($request) {
            $rankData = $this->index_data();

            $pageHtml = view('', [
                'rankData' => $rankData,
            ])->render();

            $request->session()->put('wap_index_page', $pageHtml);

            return $pageHtml;
        });

        return $indexPage;
    }

    /**
     * 小说详情页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/26 11:30
     */
    public function detail()
    {
        return view('');
    }

    public function test()
    {
        dd(11);
    }

    public static function index_data()
    {
        # 热文榜
        $bookReadDayRankRow  = BookRank::where('rank_name', 'book_read_day_rank')->first()->toArray();
        $bookReadDayRankList = json_decode($bookReadDayRankRow['content'], true);

        # 分类排行
        $bookCateogoryRow = BookRank::where('rank_name', 'book_category')->first()->toArray();
        $bookCategoryList = json_decode($bookCateogoryRow['content'], true);

        # 女生做主
        $bookWomanRecommendRow  = BookRank::where('rank_name', 'book_sex_recommend_2')->first()->toArray();
        $bookWomanRecommendList = json_decode($bookWomanRecommendRow['content'], true);

        # 男生当家
        $bookManRecommendRow  = BookRank::where('rank_name', 'book_sex_recommend_1')->first()->toArray();
        $bookManRecommendList = json_decode($bookManRecommendRow['content'], true);

        # 24小时热搜
        $bookHourSearchRow  = BookRank::where('rank_name', 'book_search_2')->first()->toArray();
        $bookHourSearchList = json_decode($bookHourSearchRow['content'], true);

        # 好看的小说
        $bookUpdateRow  = BookRank::where('rank_name', 'book_update')->first()->toArray();
        $bookUpdateList = json_decode($bookUpdateRow['content'], true);

        # 轮播图
        $bookCarouselRow  = BookRank::where('rank_name', 'book_carousel_web')->first()->toArray();
        $bookCarouselList = json_decode($bookCarouselRow['content'], true);

        return [
            'bookReadDayRankList'    => $bookReadDayRankList,
            'bookCategoryList'       => $bookCategoryList,
            'bookWomanRecommendList' => $bookWomanRecommendList,
            'bookManRecommendList'   => $bookManRecommendList,
            'bookUpdateList'         => $bookUpdateList,
            'bookHourSearchList'     => $bookHourSearchList,
            'bookCarouselList'       => $bookCarouselList,
        ];
    }

}
