<?php

namespace App\Http\Controllers\Wap;

use App\Admin\Book;
use App\Admin\BookRank;
use App\Admin\BookRecommend;
use App\Admin\Chapter;
use App\Admin\User;
use App\Admin\UserCollect;
use App\Http\Controllers\Api\ZhuishuController;
use Illuminate\Http\Request;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class BookController extends BaseController
{
    /**
     * 小说详情
     * @param $bookId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/30 10:39
     */
    public function book_detail($bookId)
    {
        # 获取小说信息

        $bookRow = Book::getBookRowById($bookId);

        if(empty($bookRow)) {
            abort(404);
        }

        # 获取小说章节末章
        $lastchapterRow = Chapter::getLastChapterRowByIdWithCache($bookId);

        # 获取小说作者其他小说
        $authorBookCount = Book::where('author_name', $bookRow['author_name'])->count();

        # 猜你喜欢小说列表
        $bookLikeList = Book::getBookListListByTypeWithCache($bookRow['type']);

        # 该小说用户书架状态
        $collectStatus = FALSE;

        # 该小说用户浏览章节记录
        $readChapterId = 0;
        $readChapterTitle = '';

        $userId = Auth::guard($this->app_guard)->id();
        if(! empty($userId))
        {
            $userCollect = UserCollect::where('user_id', $userId)->where('book_id', $bookId)->first();
            if(! empty($userCollect)) {
                $collectStatus = TRUE;
            }

            # 获取该用户是否浏览该小说
            $bookRedisHistoryList = Redis::zrevrange('zset_book_history_'.$userId,0, -1);

            if(! empty($bookRedisHistoryList))
            {
                foreach($bookRedisHistoryList as $redisHistoryBookId)
                {
                    if($redisHistoryBookId == $bookId)
                    {
                        $redisHistoryBookRow = Redis::hget('hash_book_history_'.$userId, $redisHistoryBookId);

                        $redisHistoryBookRow = explode('|', $redisHistoryBookRow);

                        $readChapterId    = $redisHistoryBookRow[1];
                        $readChapterTitle = $redisHistoryBookRow[5];

                        break;

                    }
                }
            }
        }

        return view('', [
            'bookRow'          => $bookRow,
            'lastchapterRow'   => $lastchapterRow,
            'authorBookCount'  => $authorBookCount,
            'collectStatus'    => $collectStatus,
            'bookLikeList'     => $bookLikeList,
            'readChapterId'    => $readChapterId,
            'readChapterTitle' => $readChapterTitle,
        ]);
    }

    /**
     * 章节目录
     * @param        $id
     * @param string $sort
     * @param int    $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/5 10:36
     */
    public function book_dir($id, $sort = 'asc', $page = 1)
    {
        $bookid = empty($id) ? 0 : intval($id);

        if(empty($bookid)){
            abort(404);
        }

        # 获取小说信息
        $bookRow = Book::getBookRowById($bookid);

        if(empty($bookRow)) {
            abort(404);
        }

        $chapterList = Chapter::where('book_id', $bookid)->where('status', 1)->orderBy('sort', $sort)->Paginate(100)->toArray();

        # 获取末章信息
        $lastChapterRow = Chapter::getLastChapterRowByIdWithCache($bookid);

        $result = preg_match('/第(\S+)章/', $lastChapterRow['name'], $match);

        if($result) {
            $lastChapterSort = cn2num(ltrim($match[1], '0'));
        }else {
            $lastChapterSort = $lastChapterRow['sort'];
        }

        return view('', [
            'sort'            => $sort,
            'bookRow'         => $bookRow,
            'chapterList'     => $chapterList,
            'lastChapterRow'  => $lastChapterRow,
            'lastChapterSort' => $lastChapterSort,
        ]);
    }

    /**
     * 小说章节详情
     * @param $id
     * @param $bookid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/1 15:40
     */
    public function book_chapter_detail($id, $bookid)
    {
        $bookid = empty($bookid) ? 0 : intval($bookid);

        # 获取小说信息
        $bookRow = Book::getBookRowById($bookid);

        if(empty($bookRow)) {
            abort(404);
        }

        # 获取章节信息
        if(empty($id)) {
            $chapterRow = Chapter::getFirstChapterRowByIdWithCache($bookid);
        }else {
            $chapterRow = Chapter::getChapterRowByIdWithCache($id);
        }

        # 小说阅读量增加
        Book::where('id', $bookid)->increment('read_num');

        # 获取该小说用户书架状态
        $collectStatus = FALSE;

        # 用户阅读量增加
        $userId = Auth::guard($this->app_guard)->id();
        if(! empty($userId))
        {
            User::where('id',$userId)->increment('read_num');

            $redisData = sprintf("%s|%s|%s|%s|%s|%s|%s",$bookid,$chapterRow['id'],$bookRow['name'],$bookRow['cover'], $bookRow['author_name'] ,$chapterRow['name'],time());

            # 阅读历史
            Redis::zadd('zset_book_history_' . $userId, time() , $bookRow['id']);
            Redis::expire('zset_book_history_' . $userId, 60 * 60 * 24 * 30);

            Redis::hset('hash_book_history_'.$userId, $bookRow['id'], $redisData);
            Redis::expire('hash_book_history_' . $userId, 60 * 60 * 24 * 30);

            $userCollect = UserCollect::where('user_id', $userId)->where('book_id', $bookid)->first();
            if(! empty($userCollect)) {
                $collectStatus = TRUE;
            }
        }

        # 排行榜更新
        $this->redis_rank_update($bookid, $bookRow['reader_type']);

        # 获取最后章节
        $chapterLastRow = Chapter::getLastChapterRowByIdWithCache($bookid);

        # 获取章节上一章及下一章
        $chapterNum   = empty($chapterRow['sort']) ? 0 : intval($chapterRow['sort']);

        $firstChapterSort = max($chapterNum - 1, 1);
        $lastChapterSort  = min($chapterNum + 1, $chapterLastRow['sort']);

        $chapterFirstRow = Chapter::getChapterRowByBookIdAndSortWithCache($bookid, $firstChapterSort);

        $chapterLastRow  = Chapter::getChapterRowByBookIdAndSortWithCache($bookid, $lastChapterSort);

        $chapterFirstId = $chapterFirstRow['id'];
        $chapterLastId  = $chapterLastRow['id'];

        $dbId = $chapterRow['db_id'];

        $manager = new \MongoDB\Driver\Manager("mongodb://" . config('site.mongodb_ip') . ":". config('site.mongodb_port') ."");

        $filter = ['_id' => new \MongoDB\BSON\ObjectID($dbId)];

        $options = [];

        $query = new \MongoDB\Driver\Query($filter, $options);
        $cursor = $manager->executeQuery('book.chapter', $query);

        $current_cursor = $cursor->toArray();
        if(empty($current_cursor)) {
            abort(404);
        }
        # 获取章节内容
        $chapterContent = $current_cursor[0]->content;

        return view('', [
            'chapterContent' => $chapterContent,
            'chapterRow'     => $chapterRow,
            'bookRow'        => $bookRow,
            'chapterFirstId' => $chapterFirstId,
            'chapterLastId'  => $chapterLastId,
            'collectStatus'  => $collectStatus,
        ]);
    }

    /**
     * 加载小说下一章
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/11/8 17:56
     */
    public function book_chapter_detail_load(Request $request)
    {
        $chapterId = $request->input('id');
        $bookid    = $request->input('bookid');

        $chapterId = empty($chapterId) ? 0 : intval($chapterId);

        if(empty($chapterId) || empty($bookid)){
            return $this->retJson(1, '小说章节异常');
        }

        $chapterRow = Chapter::getChapterRowById($chapterId);

        # 获取章节下一章
        $chapterNum   = empty($chapterRow['sort']) ? 0 : intval($chapterRow['sort']);

        $nextChapterSort  = max($chapterNum + 1, $chapterRow['sort']);

        $chapterNextRow  = Chapter::getChapterRowByBookIdAndSortWithCache($bookid, $nextChapterSort);

        if(empty($chapterNextRow)) {
            return $this->retJson(3, '已完结');
        }

        $dbId = $chapterNextRow['db_id'];

        $manager = new \MongoDB\Driver\Manager("mongodb://" . config('site.mongodb_ip') . ":". config('site.mongodb_port') ."");

        $filter = ['_id' => new \MongoDB\BSON\ObjectID($dbId)];

        $options = [];

        $query = new \MongoDB\Driver\Query($filter, $options);
        $cursor = $manager->executeQuery('book.chapter', $query);

        $current_cursor = $cursor->toArray();

        if(empty($current_cursor)) {
            return $this->retJson(1, '小说章节内容异常');
        }

        # 小说阅读量增加
        Book::where('id', $bookid)->increment('read_num');

        $bookRow = Book::getBookRowById($bookid);

        # 用户阅读量增加
        $userId = Auth::guard($this->app_guard)->id();

        if(! empty($userId))
        {
            User::where('id',$userId)->increment('read_num');

            $redisData = sprintf("%s|%s|%s|%s|%s|%s|%s",$bookid,$chapterNextRow['id'],$bookRow['name'],$bookRow['cover'], $bookRow['author_name'] ,$chapterNextRow['name'],time());

            # 阅读历史
            Redis::zadd('zset_book_history_' . $userId, time() , $bookRow['id']);
            Redis::expire('zset_book_history_' . $userId, 60 * 60 * 24 * 30);

            Redis::hset('hash_book_history_'.$userId, $bookRow['id'], $redisData);
            Redis::expire('hash_book_history_' . $userId, 60 * 60 * 24 * 30);
        }

        # 排行榜更新
        $this->redis_rank_update($bookid, $bookRow['reader_type']);

        # 获取章节内容
        $chapterContent = $current_cursor[0]->content;

        return $this->retJson(2, 'success' ,[
            'chapterNextRow' => $chapterNextRow,
            'chapterContent' => $chapterContent,
        ]);
    }

    /**
     * 小说排行
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/7 19:31
     */
    public function book_rank()
    {
        # 热文榜
        $bookReadDayRankRow  = BookRank::getBookRankListByRankNameWithCache('book_read_day_rank');
        $rankData['bookReadDayRankList'] = json_decode($bookReadDayRankRow['content'], true);

        # 畅销榜
        $bookHotRow  = BookRank::getBookRankListByRankNameWithCache('book_hot');
        $rankData['bookHotList'] = json_decode($bookHotRow['content'], true);

        # 点击榜
        $bookReadMonthRankRow  = BookRank::getBookRankListByRankNameWithCache('book_read_month_rank');
        $rankData['bookReadMonthRankList'] = json_decode($bookReadMonthRankRow['content'], true);

        # 推荐榜
        $bookTodayRecommendRow  = BookRank::getBookRankListByRankNameWithCache('book_today_recommend');
        $rankData['bookTodayRecommendList'] = json_decode($bookTodayRecommendRow['content'], true);

        # 男生榜
        $bookManReadWeekRankRow  = BookRank::getBookRankListByRankNameWithCache('book_man_read_week_rank');
        $rankData['bookManReadWeekRankList'] = json_decode($bookManReadWeekRankRow['content'], true);

        # 女生榜
        $bookWomanReadWeekRankRow  = BookRank::getBookRankListByRankNameWithCache('book_woman_read_week_rank');
        $rankData['bookWomanReadWeekRankList'] = json_decode($bookWomanReadWeekRankRow['content'], true);

        # 热搜榜
        $bookHourSearchRow  = BookRank::getBookRankListByRankNameWithCache('book_search_2');
        $rankData['bookHourSearchList'] = json_decode($bookHourSearchRow['content'], true);

        # 收藏榜
        $bookCollectRow  = BookRank::getBookRankListByRankNameWithCache('book_collect');
        $rankData['bookCollectList'] = json_decode($bookCollectRow['content'], true);

        # 新书榜
        $bookUpdateRow  = BookRank::getBookRankListByRankNameWithCache('book_update');
        $rankData['bookUpdateList'] = json_decode($bookUpdateRow['content'], true);

        # 潜力榜
        $bookHourSearchRow = BookRank::getBookRankListByRankNameWithCache('book_search_2');
        $rankData['bookHourSearchList'] = json_decode($bookHourSearchRow['content'], true);

        return view('', ['rankData' => $rankData]);
    }

    /**
     * 男生分版
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/7 23:07
     */
    public function book_boy()
    {
        # 轮播图
        $bookCarouselRow  = BookRank::getBookRankListByRankNameWithCache('book_carousel_wap_man');
        $bookCarouselList = json_decode($bookCarouselRow['content'], true);

        # 男生精品
        $bookManRow1  = BookRank::getBookRankListByRankNameWithCache('book_wap_man_1');
        $bookManList1 = json_decode($bookManRow1['content'], true);

        # 热血爽文
        $bookManRow2  = BookRank::getBookRankListByRankNameWithCache('book_wap_man_2');
        $bookManList2 = json_decode($bookManRow2['content'], true);

        # 今日点击榜
        $bookManReadDayRankRow  = BookRank::getBookRankListByRankNameWithCache('book_man_read_day_rank');
        $bookManReadDayRankList = json_decode($bookManReadDayRankRow['content'], true);

        return view('', [
            'bookCarouselList' => $bookCarouselList,
            'bookManRow'       => $bookManList1,
            'bookManRow2'      => $bookManList2,
            'bookManReadDayRankList' => $bookManReadDayRankList,
        ]);
    }

    /**
     * 女生分版
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/8 10:15
     */
    public function book_girl()
    {
        # 轮播图
        $bookCarouselWapRow  = BookRank::getBookRankListByRankNameWithCache('book_carousel_wap_woman');
        $bookCarouselList = json_decode($bookCarouselWapRow['content'], true);

        # 女生佳作
        $bookWomanRow1  = BookRank::getBookRankListByRankNameWithCache('book_wap_woman_1');
        $bookWomanList1 = json_decode($bookWomanRow1['content'], true);

        # 精选热文
        $bookWomanRow2  = BookRank::getBookRankListByRankNameWithCache('book_wap_woman_2');
        $bookWomanList2 = json_decode($bookWomanRow2['content'], true);

        # 今日点击榜
        $bookWomanReadDayRankRow  = BookRank::getBookRankListByRankNameWithCache('book_woman_read_day_rank');
        $bookWomanReadDayRankList = json_decode($bookWomanReadDayRankRow['content'], true);

        return view('', [
            'bookCarouselList'         => $bookCarouselList,
            'bookWomanRow'             => $bookWomanList1,
            'bookWomanRow2'            => $bookWomanList2,
            'bookWomanReadDayRankList' => $bookWomanReadDayRankList,
        ]);
    }

    /**
     * 小说分类
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/8 22:13
     */
    public function book_category()
    {
        return view('');
    }

    /**
     * 小说列表
     * @param $reader_type
     * @param $type
     * @param $word
     * @param $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/29 10:54
     */
    public function book_list($reader_type = 0, $type = 0, $word = 0, $order = 1)
    {
        $orderArr = [
            1 => 'read_num',
            2 => DB::raw('`word_count`+0'),
            3 => 'updated_at',
        ];

        $orderNum = $order;

        $whereArr = [];

        if(! empty($reader_type)) {
            $whereArr['reader_type'] = $reader_type;
        }

        if(! empty($type)) {
            $whereArr['type'] = $type;
        }

        if(! empty($word))
        {
            if($word == 1) {
                $whereArr[] = ['word_count','<=', 50];
            }elseif($word == 2) {
                $whereArr[] = ['word_count','>', 50];
                $whereArr[] = ['word_count','<=', 100];
            }else {
                $whereArr[] = ['word_count','>', 100];
            }
        }

        # 小说状态正常
        $whereArr['status'] = 2;

        $order = empty($orderArr[$order]) ? 'read_num' : $orderArr[$order];
        $bookList = Book::where($whereArr)->orderBy($order, 'DESC')->Paginate(20);

        $window = UrlWindow::make($bookList);

        $elements = [
            $window['first'],
            is_array($window['slider']) ? '...' : null,
            $window['slider'],
            is_array($window['last']) ? '...' : null,
            $window['last'],
        ];

        # 轮播图
        $bookCarouselRow  = BookRank::getBookRankListByRankNameWithCache('book_category');
        $bookCarouselList = json_decode($bookCarouselRow['content'], true)[$type];

        return view('', [
            'bookList'    => $bookList,
            'bookCarouselList'    => $bookCarouselList,
            'reader_type' => $reader_type,
            'type'        => $type,
            'word'        => $word,
            'order'       => $orderNum,
            'elements'     => $elements
        ]);
    }

    /**
     * 小说分类列表下拉加载
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/11/9 21:35
     */
    public function book_list_load(Request $request)
    {
        $type       = intval($request->input('type'));
        $searchType = trim($request->input('search_type'));

        if(empty($type)) {
            return $this->retJson(1, '数据异常');
        }

        $whereArr['type']   = $type;
        $whereArr['status'] = 2;

        switch ($searchType)
        {
            case 'popular':
                $bookList = Book::where($whereArr)->orderBy('read_num', 'DESC')->orderBy('collect_num', 'DESC')->simplePaginate(20);
                break;
            case 'word':
                $bookList = Book::where($whereArr)->orderBy(DB::raw('`word_count`+0'), 'DESC')->simplePaginate(20);
                break;
            case 'update':
                $bookList = Book::where($whereArr)->orderBy('updated_at', 'DESC')->simplePaginate(20);
                break;
            case 'collect':
                $bookList = Book::where($whereArr)->orderBy('collect_num', 'DESC')->simplePaginate(20);
                break;
            case 'read':
                $bookList = Book::where($whereArr)->orderBy('read_num', 'DESC')->simplePaginate(20);
                break;
            default:
                $bookList = Book::where($whereArr)->orderBy('read_num', 'DESC')->orderBy('collect_num', 'DESC')->simplePaginate(20);
        }

        return $this->retJson(3, '请求成功', $bookList);
    }

    /**
     * 作者列表
     * @param $bookid
     * @param $authorname
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/1 23:30
     */
    public function book_author($bookid, $authorname)
    {
        $authorname = empty($authorname) ? '' : trim($authorname);

        if(empty($authorname)) {
            abort(404);
        }

        # 获取作者小说列表
        $bookList = Book::where('author_name', $authorname)->where('status', 2)->get()->toArray();

        return view('', [
            'bookList'           => $bookList,
            'authorName'         => $authorname,
            'controllerKeywords' => $authorname,
        ]);
    }

    /**
     * 小说推荐
     * @param string $start_day
     * @param string $end_day
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/12 18:41
     */
    public function book_recommend($start_day = '', $end_day = '')
    {
        $startDay = empty($start_day) ? getLastMonday() : trim($start_day);
        $endDay   = empty($end_day) ? getLastSunday() : trim($end_day);

        $bookRecommendList = BookRecommend::getBookRecommendByStartAndEndDay($startDay, $endDay);

        $bookList = [];

        if(! empty($bookRecommendList)) {
            $bookIdArr = arrayColumns($bookRecommendList, 'book_id');
            $bookList  = Book::getBookListByIdArr($bookIdArr);
        }

        return view('', ['bookList' => $bookList]);
    }

    /**
     * 小说推荐历史列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/12 18:09
     */
    public function book_recommend_list()
    {
        $bookRecommendList = BookRecommend::getBookRecommendList();

        $bookList = [];

        if(! empty($bookRecommendList)) {
            $bookIdArr = arrayColumns($bookRecommendList, 'book_id');
            $bookList  = Book::getBookListByIdArrWithCache($bookIdArr);
        }

        return view('', ['bookList' => $bookList, 'bookRecommendList' => $bookRecommendList]);
    }

    /**
     * 浏览记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/14 17:21
     */
    public function book_history()
    {
        $userId = Auth::guard('wap')->id();
        if(empty($userId)) {
            return redirect(url('signin'));
        }

        $bookRedisHistoryList = Redis::zrevrange('zset_book_history_'.$userId,0, -1);

        $bookHistoryList = [];

        if(! empty($bookRedisHistoryList))
        {
            foreach($bookRedisHistoryList as $redisHistoryBookId)
            {
                $redisHistoryBookRow = Redis::hget('hash_book_history_'.$userId, $redisHistoryBookId);

                $redisHistoryBookRow = explode('|', $redisHistoryBookRow);

                $tmpRedisHistoryBookList = [
                    'book_id'          => $redisHistoryBookRow[0],
                    'chapter_id'       => $redisHistoryBookRow[1],
                    'book_name'        => $redisHistoryBookRow[2],
                    'book_cover'       => $redisHistoryBookRow[3],
                    'book_author_name' => $redisHistoryBookRow[4],
                    'chapter_name'     => $redisHistoryBookRow[5],
                    'read_time'        => $redisHistoryBookRow[6],
                ];

                $bookHistoryList[] = $tmpRedisHistoryBookList;
            }

        }

        return view('', ['bookHistoryList' => $bookHistoryList]);
    }

    /**
     * 书架列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/15 10:26
     */
    public function book_collect_list()
    {
        if(empty(Auth::guard('wap')->id())) {
            return redirect(url('signin'));
        }

        $userCollectList = UserCollect::where('user_id', Auth::guard('wap')->id())->get()->toArray();

        $userBookList = [];

        if(! empty($userCollectList))
        {
            $userInsideBookList = $userOutSideBookList = [];

            foreach($userCollectList as $userCollectRow)
            {
                if($userCollectRow['type'] == 1) {
                    $insideBookIdArr[] = $userCollectRow['book_id'];
                }else {
                    $outsideBookIdArr[] = $userCollectRow['book_id'];
                }
            }

            if(! empty($insideBookIdArr)) {
                $userInsideBookList = Book::getBookListByIdArrWithCache($insideBookIdArr);
            }

            if(! empty($outsideBookIdArr)) {
                try{
                    foreach($outsideBookIdArr as $outsideBookId)
                    {
                        $outsideBookRow  = (new ZhuishuController)->detail($outsideBookId);
                        $outsideBookRow  = json_decode($outsideBookRow['data'], true);

                        $tmpUserOutSideBookRow = [
                            'id'          => $outsideBookRow['_id'],
                            'cover'       => config('app.static_url').$outsideBookRow['cover'],
                            'name'        => $outsideBookRow['title'],
                            'author_name' => $outsideBookRow['author'],
                            'is_serial'   => $outsideBookRow['isSerial'],
                            'poly_status' => true
                        ];

                        $userOutSideBookList[] = $tmpUserOutSideBookRow;

                    }
                }catch (\Exception $e){
                    $userOutSideBookList = [];
                }
            }

            $userBookList = array_merge($userInsideBookList, $userOutSideBookList);
        }

        return view('', ['userBookList' => $userBookList]);
    }

    /**
     * 修改小说书架状态
     * @param $bookid
     * @return bool|\Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/3 22:21
     */
    public function book_collect(Request $request)
    {
        $book_id = $request->input('book_id');

        # 获取小说信息
        $bookRow = Book::where('id', $request->input('book_id'))->first();

        $userId = Auth::guard($this->app_guard)->id();

        if(empty($bookRow) || empty($userId)) {
            return $this->retJson(1, '未注册');
        }

        $userCollectRow = UserCollect::where('user_id', $userId)->where('book_id', $book_id)->first();

        if(empty($userCollectRow)) {
            UserCollect::create(['user_id' => $userId, 'book_id' => $book_id]);

            Book::where('id', $book_id)->increment('collect_num');

            return $this->retJson(3, '加入书架成功');
        }else {
            UserCollect::where(['user_id' => $userId, 'book_id' => $book_id])->delete();

            Book::where('id', $book_id)->decrement('collect_num');

            return $this->retJson(4, '撤出书架成功');
        }
    }

    /**
     * 书架删除
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/11/15 10:27
     */
    public function book_collect_del(Request $request)
    {
        $bookIds = empty($request->input('book_ids')) ? 0 : trim($request->input('book_ids'));

        if(empty($bookIds)) {
            return $this->retJson(2, '请选择删除小说');
        }

        $bookIdArr = array_unique(array_map('intval', explode(',', $bookIds)));

        UserCollect::whereIn('book_id', $bookIdArr)->delete();

        return $this->retJson(3, '删除成功');
    }

    /**
     * 排行榜更新
     * @param $bookId
     * @param $readerType
     * @return bool
     * @author shenruxiang
     * @date 2018/10/28 15:42
     */
    public function redis_rank_update($bookId, $readerType)
    {
        $bookId = empty($bookId) ? 0 : intval($bookId);

        if(empty($bookId)) {
            return FALSE;
        }

        #----总榜----
        # 日
        Redis::zincrby('book_read_day_rank', 1, $bookId);
        # 周
        Redis::zincrby('book_read_week_rank', 1, $bookId);
        # 月
        Redis::zincrby('book_read_month_rank', 1, $bookId);

        if($readerType == 1)
        {
            #----男榜----
            # 日
            Redis::zincrby('book_man_read_day_rank', 1, $bookId);
            # 周
            Redis::zincrby('book_man_read_week_rank', 1, $bookId);
            # 月
            Redis::zincrby('book_man_read_month_rank', 1, $bookId);
        }else if($readerType == 2)
        {
            #----女榜----
            # 日
            Redis::zincrby('book_woman_read_day_rank', 1, $bookId);
            # 周
            Redis::zincrby('book_woman_read_week_rank', 1, $bookId);
            # 月
            Redis::zincrby('book_woman_read_month_rank', 1, $bookId);
        }
    }
}
