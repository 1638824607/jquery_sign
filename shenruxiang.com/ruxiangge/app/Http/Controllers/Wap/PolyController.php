<?php

namespace App\Http\Controllers\Wap;

use App\Admin\Book;
use App\Admin\User;
use App\Admin\UserCollect;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\ZhuishuController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PolyController extends BaseController
{
    public function cate_list()
    {
        $responseCateList = (new ZhuishuController)->cate_listWithCache();

        if($responseCateList['status'] != 2) {
            abort(404);
        }

        return view('', ['cateList' => json_decode($responseCateList['data'], true)]);
    }

    public function cate(Request $request)
    {
        if($request->isMethod('post'))
        {
            $gender = empty($request->input('gender')) ? 'male' : trim($request->input('gender'));
            $type   = empty($request->input('type')) ? 'hot' : trim($request->input('type'));
            $major  = empty($request->input('major')) ? '玄幻' : trim($request->input('major'));
            $minor  = empty($request->input('minor')) ? '' : trim($request->input('minor'));

            $start = empty($request->input('start')) ? 1 : intval($request->input('start'));
            $limit = 20;

            $urlParam = [
                'gender' => $gender,
                'type'   => $type,
                'major'  => $major,
                'minor'  => $minor,
                'start'  => ($start-1)*$limit,
                'limit'  => $limit
            ];

            $responseCateBookList = (new ZhuishuController)->cateWithCache($urlParam);

            if($responseCateBookList['status'] != 2) {
                return $this->retJson(3,'fail', $responseCateBookList['data']);
            }

            return $this->retJson(2,'success', json_decode($responseCateBookList['data'], true));
        }else {
            $gender = empty($request->input('gender')) ? 'male' : trim($request->input('gender'));
            $major  = empty($request->input('major')) ? '玄幻' : trim($request->input('major'));

            $responseCateLvList = (new ZhuishuController)->cate_lvWithCache();

            $cateLvList = [];

            try{
                $responseCateLvList = json_decode($responseCateLvList['data'], true);

                if((! empty($gender)) && (! empty($major))) {
                    $cateLvList = $responseCateLvList[$gender];

                    $cateLvList = array_column($cateLvList,NULL,'major');

                    $cateLvList = $cateLvList[$major]['mins'];
                }


            }catch (\Exception $e){
                $cateLvList = [];
            }

            return view('', [
                'gender'      => $gender,
                'major'       => $major,
                'cateLvList'  => $cateLvList
            ]);
        }
    }

    public function detail(Request $request, $bookId)
    {
        $bookId = empty($bookId) ? '' : trim($bookId);

        if(empty($bookId)) {
            abort(404);
        }

        $responseBookRow = (new ZhuishuController)->detailWithCache($bookId);

        if($responseBookRow['status'] != 2) {
            abort(404);
        }

        $bookRow = json_decode($responseBookRow['data'], true);

        $responseAuthorRow = (new ZhuishuController)->authorWithCache($bookRow['author']);

        try{
            $responseAuthorCount = count(json_decode($responseAuthorRow['data'], true)['books']);
        }catch (\Exception $e){
            $responseAuthorCount = 0;
        }

        # 猜你喜欢
        $urlParam = [
            'gender' => $bookRow['gender'][0] ?: 'male',
            'type'   => 'hot',
            'major'  => $bookRow['majorCate'],
            'start'  => 0,
            'limit'  => 20
        ];

        $responseCateBookList = (new ZhuishuController)->cateWithCache($urlParam);

        $likeBookList = [];

        if(! empty($responseCateBookList) && $responseCateBookList['status'] == 2) {
            $likeBookList = json_decode($responseCateBookList['data'], true);

            if(! empty($likeBookList) && ! empty($likeBookList['books'])) {
                shuffle($likeBookList['books']);
                $likeBookList = array_slice($likeBookList['books'],1,6);
            }
        }

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
            'bookRow'             => $bookRow,
            'responseAuthorCount' => $responseAuthorCount,
            'likeBookList'        => $likeBookList,
            'collectStatus'       => $collectStatus,
            'readChapterId'       => $readChapterId,
            'readChapterTitle'    => $readChapterTitle,
            ]
        );
    }

    public function content(Request $request, $chapterId, $bookId)
    {
        $bookId     = empty($bookId) ? 0 : trim($bookId);
        $chapterId = empty($chapterId) ? 0 : intval($chapterId);

        if(empty($bookId)) {
            abort(404);
        }

        $bookName = $chapterTitle = $chapterContent = $bookCover = $bookAuthorName = '';

        try{
            $bookRow        = (new ZhuishuController)->detail($bookId);
            $bookRow        = json_decode($bookRow['data'], true);
            $bookName       = $bookRow['title'];
            $bookCover      = config('app.static_url').$bookRow['cover'];
            $bookAuthorName = $bookRow['author'];

            $atocBookList = (new ZhuishuController)->min_atoc($bookId);

            $atocBookList = json_decode($atocBookList['data'], true);

            $minChapter = 0;
            $maxChapter = count($atocBookList['mixToc']['chapters']) - 1;

            if($maxChapter < $chapterId)
            {
                if($request->isMethod('post')) {
                    return $this->retJson('3', 'end');
                }

                $chapterId = min($maxChapter, $chapterId);
            }

            $chapterId = max($minChapter, $chapterId);

            $atocBookLink = $atocBookList['mixToc']['chapters'][$chapterId]['link'];
            $chapterTitle = $atocBookList['mixToc']['chapters'][$chapterId]['title'];

            $chapterContent = (new ZhuishuController)->content($atocBookLink);
            $chapterContent = json_decode($chapterContent['data'], true)['chapter']['body'];
            $chapterContent = str_replace(PHP_EOL, "<br>　　",$chapterContent);

        }catch (\Exception $e){
            abort(404);
        }

        $renderData = [
            'bookName'       => $bookName,
            'chapterTitle'   => $chapterTitle,
            'chapterContent' => $chapterContent,
            'chapterId'      => $chapterId,
            'bookId'         => $bookId
        ];

        $userId = Auth::guard($this->app_guard)->id();

        if(! empty($userId))
        {
            User::where('id',$userId)->increment('read_num');

            $redisData = sprintf("%s|%s|%s|%s|%s|%s|%s",$bookId,$chapterId,$bookName,$bookCover, $bookAuthorName ,$chapterTitle,time());

            # 阅读历史
            Redis::zadd('zset_book_history_' . $userId, time() , $bookId);
            Redis::expire('zset_book_history_' . $userId, 60 * 60 * 24 * 30);

            Redis::hset('hash_book_history_'.$userId, $bookId, $redisData);
            Redis::expire('hash_book_history_' . $userId, 60 * 60 * 24 * 30);
        }


        if($request->isMethod('post')) {
            return $this->retJson('2', 'success', $renderData);
        }else {
            $renderData['collectStatus'] = false;

            if(! empty($userId)) {
                $userCollect = UserCollect::where('user_id', $userId)->where('book_id', $bookId)->first();
                if(!empty($userCollect)) {
                    $renderData['collectStatus'] = TRUE;
                }
            }

            return view('', $renderData);
        }
    }

    public function dir($bookId)
    {
        $bookId = empty($bookId) ? 0 : trim($bookId);

        if(empty($bookId)) {
            abort(404);
        }

        $chapterList = $bookRow = [];

        try{
            $bookRow  = (new ZhuishuController)->detailWithCache($bookId);
            $bookRow  = json_decode($bookRow['data'], true);

            $atocBookList = (new ZhuishuController)->min_atocWithCache($bookId);

            $atocBookList = json_decode($atocBookList['data'], true);

            $chapterList = $atocBookList['mixToc']['chapters'];
        }catch (\Exception $e){
            abort(404);
        }

        return view('', [
            'chapterList' => $chapterList,
            'bookRow'     => $bookRow,
        ]);

    }

    public function collect(Request $request)
    {
        $bookId = $request->input('book_id');

        $userId = Auth::guard($this->app_guard)->id();

        if(empty($bookId) || empty($userId)) {
            return $this->retJson(1, 'error');
        }

        $userCollectRow = UserCollect::where('user_id', $userId)->where('book_id', $bookId)->first();

        if(empty($userCollectRow)) {
            UserCollect::create(['user_id' => $userId, 'book_id' => $bookId, 'type' => 2]);

            return $this->retJson(3, '加入书架成功');
        }else {
            UserCollect::where(['user_id' => $userId, 'book_id' => $bookId])->delete();

            return $this->retJson(4, '撤出书架成功');
        }
    }

    public function author($authorName)
    {
        $authorName = empty($authorName) ? '' : trim($authorName);
        if(empty($authorName)) {
            abort(404);
        }

        $responseAuthorRow = (new ZhuishuController)->authorWithCache($authorName);

        try{
            $responseAuthorList = json_decode($responseAuthorRow['data'], true)['books'];
        }catch (\Exception $e){
            $responseAuthorList = [];
        }

        return view('', [
            'authorName' => $authorName,
            'bookList'   => $responseAuthorList
        ]);
    }

    public function book_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $sort     = $request->input('sort');
            $duration = $request->input('duration');
            $gender   = $request->input('gender');
            $tag      = $request->input('tag');
            $start    = $request->input('start');

            $responseBookList = (new ZhuishuController)->book_listWithCache($sort , $duration, $gender, $tag, $start);

            try{
                $bookList = json_decode($responseBookList['data'], true)['bookLists'];
            }catch (\Exception $e){
                $bookList = [];
            }

            return $this->retJson(2,'success', $bookList);
        }else {
            return view('');
        }
    }

    public function book_detail($bookListId)
    {
        $responseBookList = (new ZhuishuController)->book_list_detailWithCache($bookListId);

        try{
            $bookDetailList = json_decode($responseBookList['data'], true)['bookList'];
        }catch (\Exception $e){
            $bookDetailList = [];
        }

        return view('', ['bookDetailList' => $bookDetailList]);
    }

    public function rank($gender)
    {
        $gender = empty($gender) ? 'male' : trim($gender);

        $responseRankList = (new ZhuishuController)->book_rankWithCache();

        try{
            $rankList = json_decode($responseRankList['data'], true)[$gender];
        }catch (\Exception $e){
            $rankList = [];
        }

        return view('', [
            'gender'   => $gender,
            'rankList' => $rankList
        ]);
    }

    public function rank_detail($rankId, $gender)
    {
        $rankId = empty($rankId) ? '' : trim($rankId);

        $responseRankBookList = (new ZhuishuController)->book_rank_detailWithCache($rankId);

        try{
            $rankBookList = json_decode($responseRankBookList['data'], true)['ranking']['books'];
        }catch (\Exception $e){
            $rankBookList = [];
        }

        return view('', [
            'gender' => $gender,
            'rankBookList' => $rankBookList
        ]);
    }

    public function outside_search()
    {
        try{
            $searchHotwordList = (new ZhuishuController)->search_hotwords();
            $searchHotwordList = json_decode($searchHotwordList['data'], true)['searchHotWords'];
        }catch (\Exception $e){
            $searchHotwordList = [];
        }

        $searchHistoryList = [];

        if(isset($_COOKIE['search_history'])) {
            $searchHistoryList = json_decode($_COOKIE['search_history']);
        }

        return view('', [
            'searchHotwordList' => $searchHotwordList,
            'searchHistoryList' => $searchHistoryList
        ]);
    }

    public function outside_search_list($content)
    {
        $content = empty($content) ? '' : trim($content);

        if(empty($content)) {
            return redirect(url('outside_search'));
        }

        try{
            $searchList = (new ZhuishuController)->search_fuzzy($content);

            $searchList = json_decode($searchList['data'], true)['books'];

        }catch (\Exception $e){
            $searchList = [];
        }

        $searchHistoryList = [];

        if(isset($_COOKIE['search_history'])) {
            $searchHistoryList = json_decode($_COOKIE['search_history']);

            if(count($searchHistoryList) > 6) {
                array_shift($searchHistoryList);
            }
        }

        if(! in_array($content, $searchHistoryList)) {
            array_push($searchHistoryList, $content);
        }

        setcookie("search_history", json_encode($searchHistoryList), time() + 365 * 24 * 60 * 60, '/');


        return view('', [
            'searchList'    => $searchList,
            'searchContent' => $content
        ]);
    }

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
                $userInsideBookList = Book::whereIn('id', $insideBookIdArr)->get()->toArray();
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

    public function user()
    {
        $userId = Auth::guard('wap')->id();
        if(empty($userId)) {
            return redirect(url('signin'));
        }

        $userCollectList = UserCollect::where('user_id', $userId)->get()->toArray();

        $bookList = [];

        if(! empty($userCollectList)) {
            $bookIdArr = arrayColumns($userCollectList, 'book_id');

            $userBookList = Book::whereIn('id', $bookIdArr)->get()->toArray();

            if(! empty($userBookList)) {
                $bookListCount = count($userBookList);

                for($i = 0; $i < ceil($bookListCount); $i++)
                {
                    $bookList[] = array_slice($userBookList, $i * 4 ,4);
                }
            }
        }

        return view('', ['bookList' => $bookList, 'user' => $userId]);
    }





















    public function yaozhanhui(Request $request)
    {
        if($request->isMethod('post'))
        {
            $gender = empty($request->input('gender')) ? 'male' : trim($request->input('gender'));
            $type   = empty($request->input('type')) ? 'hot' : trim($request->input('type'));
            $major  = empty($request->input('major')) ? '玄幻' : trim($request->input('major'));
            $minor  = empty($request->input('minor')) ? '' : trim($request->input('minor'));

            $start = empty($request->input('start')) ? 1 : intval($request->input('start'));
            $limit = 20;

            $urlParam = [
                'gender' => $gender,
                'type'   => $type,
                'major'  => $major,
                'minor'  => $minor,
                'start'  => ($start-1)*$limit,
                'limit'  => $limit
            ];

            $responseCateBookList = (new ZhuishuController)->cate($urlParam);

            if($responseCateBookList['status'] != 2) {
                return $this->retJson(3,'fail', $responseCateBookList['data']);
            }

            return $this->retJson(2,'success', json_decode($responseCateBookList['data'], true));
        }

        abort(404);
    }
}
