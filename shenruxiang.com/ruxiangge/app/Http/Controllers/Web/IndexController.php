<?php

namespace App\Http\Controllers\Web;

use App\Admin\Book;
use App\Admin\BookRank;
use App\Admin\News;
use App\Http\Controllers\Api\ZhuishuController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class IndexController extends BaseController
{
    /**
     * 前台首页
     * @param Request $request
     * @return mixed
     * @author shenruxiang
     * @date 2018/11/13 11:18
     */
    public function index(Request $request)
    {
        $indexPage = $request->session()->get('index_page', function () use($request) {
            # 获取轮播图列表
            $carouselList = Book::where('status', 2)->where('is_carousel', 2)->orderBy('sort', 'DESC')->get()->toArray();

            # 获取友情链接
            $newList = Cache::rememberForever('new_list', function() {
                return News::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray();
            });

            $rankData = $this->index_data();

            $pageHtml = view('', [
                'carouselList' => $carouselList,
                'rankData'     => $rankData,
                'newList'      => $newList,
            ])->render();

            $request->session()->put('index_page', $pageHtml);


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

    public function download_android_apk(Request $request)
    {
        return response()->download(storage_path('app/public/apk/shenruxiang1.apk'),'shenruxiang.apk',$headers = ['Content-Type'=>'application/zip;charset=utf-8']);

    }

    public function privacy()
    {
        return view('');
    }

    public function index_data()
    {
        # 热文榜
        # 日
        $bookReadDayRankRow  = BookRank::where('rank_name', 'book_read_day_rank')->first()->toArray();
        $bookReadDayRankList = json_decode($bookReadDayRankRow['content'], true);

        # 周
        $bookReadWeekRankRow  = BookRank::where('rank_name', 'book_read_week_rank')->first()->toArray();
        $bookReadWeekRankList = json_decode($bookReadWeekRankRow['content'], true);

        # 月
        $bookReadMonthRankRow  = BookRank::where('rank_name', 'book_read_month_rank')->first()->toArray();
        $bookReadMonthRankList = json_decode($bookReadMonthRankRow['content'], true);

        # 主编力推
        $bookRecommendRow  = BookRank::where('rank_name', 'book_recommend')->first()->toArray();
        $bookRecommendList = json_decode($bookRecommendRow['content'], true);

        # 分类排行
        $bookCateogoryRow = BookRank::where('rank_name', 'book_category')->first()->toArray();
        $bookCategoryList = json_decode($bookCateogoryRow['content'], true);

        # 当红文
        $bookHotRow  = BookRank::where('rank_name', 'book_hot')->first()->toArray();
        $bookHotList = json_decode($bookHotRow['content'], true);

        # 网友热搜

        # 今日推荐
        $bookTodayRecommendRow  = BookRank::where('rank_name', 'book_today_recommend')->first()->toArray();
        $bookTodayRecommendList = json_decode($bookTodayRecommendRow['content'], true);

        # 女生做主
        $bookWomanRecommendRow  = BookRank::where('rank_name', 'book_sex_recommend_2')->first()->toArray();
        $bookWomanRecommendList = json_decode($bookWomanRecommendRow['content'], true);

        # 男生当家
        $bookManRecommendRow  = BookRank::where('rank_name', 'book_sex_recommend_1')->first()->toArray();
        $bookManRecommendList = json_decode($bookManRecommendRow['content'], true);

        # 公共版权

        # 男生榜
        # 日
        $bookManReadDayRankRow  = BookRank::where('rank_name', 'book_man_read_day_rank')->first()->toArray();
        $bookManReadDayRankList = json_decode($bookManReadDayRankRow['content'], true);

        # 周
        $bookManReadWeekRankRow  = BookRank::where('rank_name', 'book_man_read_week_rank')->first()->toArray();
        $bookManReadWeekRankList = json_decode($bookManReadWeekRankRow['content'], true);

        # 月
        $bookManReadMonthRankRow  = BookRank::where('rank_name', 'book_man_read_month_rank')->first()->toArray();
        $bookManReadMonthRankList = json_decode($bookManReadMonthRankRow['content'], true);

        # 女生榜
        # 日
        $bookWomanReadDayRankRow  = BookRank::where('rank_name', 'book_woman_read_day_rank')->first()->toArray();
        $bookWomanReadDayRankList = json_decode($bookWomanReadDayRankRow['content'], true);

        # 周
        $bookWomanReadWeekRankRow  = BookRank::where('rank_name', 'book_woman_read_week_rank')->first()->toArray();
        $bookWomanReadWeekRankList = json_decode($bookWomanReadWeekRankRow['content'], true);

        # 月
        $bookWomanReadMonthRankRow  = BookRank::where('rank_name', 'book_woman_read_month_rank')->first()->toArray();
        $bookWomanReadMonthRankList = json_decode($bookWomanReadMonthRankRow['content'], true);

        # 公版书榜

        # 网友热搜
        $bookHotSearchRow  = BookRank::where('rank_name', 'book_search_1')->first()->toArray();
        $bookHotSearchList = json_decode($bookHotSearchRow['content'], true);

        # 24小时热搜
        $bookHourSearchRow  = BookRank::where('rank_name', 'book_search_2')->first()->toArray();
        $bookHourSearchList = json_decode($bookHourSearchRow['content'], true);

        # 好看的小说
        $bookUpdateRow  = BookRank::where('rank_name', 'book_update')->first()->toArray();
        $bookUpdateList = json_decode($bookUpdateRow['content'], true);

        # 实时收藏
        $bookUpdateCollectRow  = BookRank::where('rank_name', 'book_update_collect')->first()->toArray();
        $bookUpdateCollectList = json_decode($bookUpdateCollectRow['content'], true);

        # 收藏榜
        $bookCollectRow  = BookRank::where('rank_name', 'book_collect')->first()->toArray();
        $bookCollectList = json_decode($bookCollectRow['content'], true);

        # 轮播图
        $bookCarouselRow  = BookRank::where('rank_name', 'book_carousel_web')->first()->toArray();
        $bookCarouselList = json_decode($bookCarouselRow['content'], true);

        return [
            'bookReadDayRankList'    => $bookReadDayRankList,
            'bookReadWeekRankList'   => $bookReadWeekRankList,
            'bookReadMonthRankList'  => $bookReadMonthRankList,
            'bookRecommendList'      => $bookRecommendList,
            'bookCategoryList'       => $bookCategoryList,
            'bookHotList'            => $bookHotList,
            'bookTodayRecommendList' => $bookTodayRecommendList,
            'bookWomanRecommendList' => $bookWomanRecommendList,
            'bookManRecommendList'   => $bookManRecommendList,
            'bookWomanReadDayRankList'   => $bookWomanReadDayRankList,
            'bookWomanReadWeekRankList'  => $bookWomanReadWeekRankList,
            'bookWomanReadMonthRankList' => $bookWomanReadMonthRankList,
            'bookManReadDayRankList'     => $bookManReadDayRankList,
            'bookManReadWeekRankList'    => $bookManReadWeekRankList,
            'bookManReadMonthRankList'   => $bookManReadMonthRankList,
            'bookCollectList'            => $bookCollectList,
            'bookUpdateList'             => $bookUpdateList,
            'bookUpdateCollectList'      => $bookUpdateCollectList,
            'bookHotSearchList'          => $bookHotSearchList,
            'bookHourSearchList'         => $bookHourSearchList,
            'bookCarouselList'           => $bookCarouselList,
        ];
    }

}
