<?php

namespace App\Http\Controllers\Web;

use App\Admin\Book;
use App\Admin\BookType;
use App\Admin\Chapter;
use App\Admin\User;
use App\Admin\UserCollect;
use Illuminate\Http\Request;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\URL;

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
        $bookRow = Book::where('id', $bookId)->where('status', 2)->first();

        if(empty($bookRow)) {
            abort(404);
        }

        # 获取小说章节列表
        $chapterList = Chapter::where('book_id', $bookId)->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();

        # 获取小说最新章节默认6条
        $newChapterList = array_slice($chapterList,-6);

        # 获取小说作者其他小说
        $authorBookList = Book::where('author_name', $bookRow['author_name'])->where('id', '!=' , $bookId)->orderBy('id', 'DESC')->get()->toArray();

        # 猜你喜欢小说列表
        $bookLikeList = Cache::remember('book_like_list_'.$bookRow['reader_type'], 60, function () use($bookRow) {
            return Book::where('status', 2)->where('reader_type', $bookRow['reader_type'])->orderBy(DB::raw('RAND()'))
                ->take(10)
                ->get()->toArray();
        });

        # 获取该小说用户书架状态
        $collectStatus = FALSE;

        $userId = Auth::guard($this->app_guard)->id();
        if(! empty($userId))
        {
            $userCollect = UserCollect::where('user_id', $userId)->where('book_id', $bookId)->first();
            if(! empty($userCollect)) {
                $collectStatus = TRUE;
            }
        }

        return view('', [
            'bookRow'        => $bookRow,
            'chapterList'    => $chapterList,
            'newChapterList' => $newChapterList,
            'authorBookList' => $authorBookList,
            'collectStatus'  => $collectStatus,
            'bookLikeList'   => $bookLikeList,
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

        if(empty($bookid)){
            abort(404);
        }

        # 获取小说信息
        $bookRow = Book::where('id', $bookid)->first();

        if(empty($bookRow)) {
            abort(404);
        }

        # 获取章节信息
        if(empty($id)) {
            $chapterRow = Chapter::where('book_id', $bookid)->orderBy('sort', 'ASC')->first();
        }else {
            $chapterRow = Chapter::where('id', $id)->first();
        }

        # 小说阅读量增加
        Book::where('id', $bookid)->increment('read_num');

        # 用户阅读量增加
        $userId = Auth::guard($this->app_guard)->id();
        if(! empty($userId))
        {
            User::where('id',$userId)->increment('read_num');

            $redisData = sprintf("%s|%s|%s|%s", $bookid, $chapterRow['id'], $bookRow['name'], $chapterRow['name']);

            # 阅读历史
            Redis::zadd('book_history_' . $userId, time() , $redisData);
            Redis::expire('book_history_' . $userId, 60 * 60 * 24 * 30);

            $redisData = sprintf("%s|%s|%s|%s|%s|%s|%s",$bookid,$chapterRow['id'],$bookRow['name'],$bookRow['cover'], $bookRow['author_name'] ,$chapterRow['name'],time());

            # 阅读历史
            Redis::zadd('zset_book_history_' . $userId, time() , $bookRow['id']);
            Redis::expire('zset_book_history_' . $userId, 60 * 60 * 24 * 30);

            Redis::hset('hash_book_history_'.$userId, $bookRow['id'], $redisData);
            Redis::expire('hash_book_history_' . $userId, 60 * 60 * 24 * 30);
        }

        # 排行榜更新
        $this->redis_rank_update($bookid, $bookRow['reader_type']);

        # 获取最后章节
        $chapterLastRow = Chapter::where('book_id', $bookid)->orderBy('sort', 'DESC')->first()->toArray();

        # 获取章节上一章及下一章
        $chapterNum   = empty($chapterRow['sort']) ? 0 : intval($chapterRow['sort']);

        $firstChapterSort = max($chapterNum - 1, 1);
        $lastChapterSort  = min($chapterNum + 1, $chapterLastRow['sort']);

        $chapterFirstRow = Chapter::where('sort', $firstChapterSort)->where('book_id', $bookid)->first();
        $chapterLastRow  = Chapter::where('sort', $lastChapterSort)->where('book_id', $bookid)->first();

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
        ]);
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
            3 => 'created_at',
        ];

        $orderNum = $order;

        $whereArr = [
            'status' => 2
        ];

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

        return view('', [
            'bookList'    => $bookList,
            'reader_type' => $reader_type,
            'type'        => $type,
            'word'        => $word,
            'order'       => $orderNum,
            'elements'     => $elements
        ]);
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
        # 获取小说信息
        $bookRow = Book::where('id', $bookid)->first();

        # 获取作者小说列表
        $bookList = Book::where('author_name', $authorname)->get()->toArray();

        $bookViewList = [];

        if(! empty($bookList)) {
            $bookListCount = count($bookList);

            for($i = 0; $i < ceil($bookListCount); $i++)
            {
                $bookViewList[] = array_slice($bookList, $i * 4 ,4);
            }
        }

        return view('', ['bookRow' => $bookRow, 'bookList' => $bookViewList, 'authorName' => $authorname]);
    }

    /**
     * 小说推荐
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/29 15:05
     */
    public function book_recommend()
    {
        return view('');
    }

    /**
     * 加入书架
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

            return $this->retJson(4, '取消加入书架成功');
        }
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
