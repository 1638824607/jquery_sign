<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Book;
use App\Admin\BookReader;
use App\Admin\BookType;
use App\Admin\Chapter;
use App\Admin\MongoChapter;
use App\Admin\ReptileLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BookController extends BaseController
{
    /**
     * 小说列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/9 17:29
     */
    public function book_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $whereData = $request->input();

            $whereArr = [];

            if(! empty($whereData['id'])) {
                $whereArr['id'] = $whereData['id'];
            }

            if(! empty($whereData['author_name'])) {
                $whereArr[] = ['author_name', 'like', '%'. $whereData['author_name'] .'%'];
            }

            if(! empty($whereData['name'])) {
                $whereArr[] = ['name', 'like', '%'. $whereData['name'] .'%'];
            }

            if(! empty($whereData['reader_type'])) {
                $whereArr['reader_type'] = $whereData['reader_type'];
            }

            if(! empty($whereData['type'])) {
                $whereArr['type'] = $whereData['type'];
            }

            if(! empty($whereData['status'])) {
                $whereArr['status'] = $whereData['status'];
            }

            if(! empty($whereData['is_carousel'])) {
                $whereArr['is_carousel'] = $whereData['is_carousel'];
            }

//            if(! empty($whereArr)) {
//                $request->merge(['page' => '1']);
//            }

            $bookList = Book::where($whereArr)->Paginate($request->input('limit'))->toArray();

            return $this->retJsonTableData($bookList['data'], $bookList['total']);
        }else
        {
            # 获取小说阅读类型
            $bookReaderList = Cache::rememberForever('book_reader_list', function() {
                return BookReader::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray();
            });

            # 获取小说类型
            $bookTypeList = Cache::rememberForever('book_type_list', function() {
                return BookType::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray();
            });

            return view('', ['bookReaderList' => $bookReaderList, 'bookTypeList' => $bookTypeList]);
        }
    }

    /**
     * 小说缩略图上传
     * @param Request $request
     * @return false|string
     * @author shenruxiang
     * @date 2018/8/9 22:07
     */
    public function book_cover_upload(Request $request)
    {
        $covePath = $request->file('file')->store('book_cover');

        return response()->json([
            'code' => 0,
            'msg'  => '上传成功',
            'data' => '/storage/' . $covePath
        ]);
    }

    /**
     * 修改或添加小说
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/9 22:47
     */
    public function book_save(Request $request)
    {
        $bookRow = $request->input();

        if(! empty($bookRow['id'])) {
            Book::where('id', $bookRow['id'])->update($bookRow);
        }else {
            Book::create($bookRow);
        }

        return $this->retJson(3, '操作成功');
    }

    /**
     * 删除小说
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/9 23:21
     */
    public function book_del(Request $request)
    {
        $bookId = intval($request->input('id'));

        if(empty($bookId)) {
            return $this->retJson(2, '删除失败');
        }

        # 删除mongo章节文档
        $bulk = new \MongoDB\Driver\BulkWrite;

        # 获取小说章节列表
        $chapterList = Chapter::where('book_id', $bookId)->get()->toArray();

        if(! empty($chapterList))
        {
            foreach($chapterList as $chapter)
            {
                if(! empty($chapter['db_id'])) {
                    $bulk->delete(['_id' => new \MongoDB\BSON\ObjectID($chapter['db_id'])]);
                }
            }

            $manager = new \MongoDB\Driver\Manager("mongodb://" . config('site.mongodb_ip') . ":". config('site.mongodb_port') ."");

            $manager->executeBulkWrite('book.chapter', $bulk);
        }

        # 删除小说
        Book::where('id', $bookId)->delete();

        # 删除章节
        Chapter::where('book_id', $bookId)->delete();

        return $this->retJson(3, '删除成功');
    }

    /**
     * 章节列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/10 15:50
     */
    public function book_chapter_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $whereData = $request->input();

            $whereArr = [];

            # 默认排序
            $orderField = 'id';
            $orderOrder = 'DESC';

            if(! empty($whereData['id'])) {
                $whereArr['id'] = $whereData['id'];
            }

            if(! empty($whereData['book_id'])) {
                $whereArr['book_id'] = $whereData['book_id'];

                $orderField = 'sort';
                $orderOrder = 'ASC';
            }

            if(! empty($whereData['title'])) {
                $whereArr[] = ['title', 'like', '%'. $whereData['title'] .'%'];
            }

            if(! empty($whereData['status'])) {
                $whereArr['status'] = $whereData['status'];
            }

            $chapterList = Chapter::where($whereArr)->orderBy($orderField, $orderOrder)->Paginate($request->input('limit'))->toArray();

            return $this->retJsonTableData($chapterList['data'], $chapterList['total']);
        }else {
            $book_id = $request->input('book_id');

            $book_list = Book::get()->keyBy('id')->toArray();

            return view('', ['book_id' => $book_id, 'book_list' => $book_list]);
        }
    }

    /**
     * 小说章节修正列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/14 17:41
     */
    public function book_chapter_check(Request $request)
    {
        $book_id = intval($request->input('book_id'));
        if($request->isMethod('post'))
        {
            $chapterList = Chapter::where('book_id', $book_id)->orderBy('sort', 'ASC')->get()->toArray();

            return $this->retJsonTableData($chapterList);
        }else
        {
            if(empty($book_id)) {
                abort(404);
            }

            # 获取小说信息
            $bookRow = Book::where('id', $book_id)->first()->toArray();

            return view('', ['bookRow' => $bookRow]);
        }
    }

    /**
     * 修改章节排序及章节名称
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/18 17:13
     */
    public function book_chapter_edit(Request $request)
    {
        $chapterRow = $request->input();

        $chapterId = empty($chapterRow['id']) ? 0 : intval($chapterRow['id']);

        if(empty($chapterId)) {
            return $this->retJson(2, '章节修改失败');
        }

        Chapter::where('id', $chapterId)->update([$chapterRow['field'] => $chapterRow['value']]);

        return $this->retJson(3, '章节修改成功');
    }

    /**
     * 章节生成排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/17 22:13
     */
    public function book_chapter_sort_create(Request $request)
    {
        $bookId = intval($request->input('book_id'));

        if(empty($bookId)) {
            return $this->retJson(2, '章节排序生成失败');
        }

        $chapterTotal = Chapter::where('book_id', $bookId)->count();

        $pageNum   = 100;
        $totalPage = ceil($chapterTotal / $pageNum) + 1;

        $startChapterId = 0;
        $chapterSort = $chapterTotal;

        for($page = 1; $page <= $totalPage; $page++)
        {
            $chapterList = Chapter::where('book_id', $bookId)->where('id', '>', $startChapterId)->limit($pageNum)->get()->toArray();

            if(empty($chapterList)) {
                break;
            }

            # 获取下一次的查询的起始ID
            $startChapterId = max(arrayColumns($chapterList, 'id'));

            foreach($chapterList as $chapter)
            {
                Chapter::where('id', $chapter['id'])->update(['sort' => $chapterSort]);

                $chapterSort--;
            }
        }

        return $this->retJson(3, '章节排序生成成功');
    }

    /**
     * 章节排序再生成
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/19 16:14
     */
    public function book_chapter_sort_recreate(Request $request)
    {
        $bookId = intval($request->input('book_id'));

        if(empty($bookId)) {
            return $this->retJson(2, '章节排序生成失败');
        }

        $chapterList = Chapter::where('book_id', $bookId)->orderBy('sort', 'ASC')->get();

        if(empty($chapterList)) {
            return $this->retJson(2, '章节排序生成失败');
        }

        $chapterSort = 1;

        foreach($chapterList as $chapter)
        {
            Chapter::where('id', $chapter['id'])->update(['sort' => $chapterSort]);

            $chapterSort++;
        }

        return $this->retJson(3, '章节排序生成成功');
    }

    /**
     * 章节名称格式化
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/19 10:15
     */
    public function chapter_name_recreate(Request $request)
    {
        $bookId = intval($request->input('book_id'));

        if(empty($bookId)) {
            return $this->retJson(3, '数据异常');
        }

        $chapterTotal = Chapter::where('book_id', $bookId)->count();

        $pageNum   = 100;
        $totalPage = ceil($chapterTotal / $pageNum) + 1;

        $startChapterId = 0;

        for($page = 1; $page <= $totalPage; $page++)
        {
            $chapterList = Chapter::where('book_id', $bookId)->where('id', '>', $startChapterId)->limit($pageNum)->get()->toArray();

            if(empty($chapterList)) {
                break;
            }

            # 获取下一次的查询的起始ID
            $startChapterId = max(arrayColumns($chapterList, 'id'));

            foreach($chapterList as $chapter)
            {
                $currentChapterName = $chapter['name'];
                $result1 = preg_match('/第(\d+)章/', $currentChapterName, $match);

                if($result1) {
                    $numWord = numToWord(ltrim($match[1], '0'));
                    $currentChapterName = str_replace($match[1], $numWord, $currentChapterName);
                }

                $strPos = strpos($currentChapterName, '第');

                $currentChapterName = substr($currentChapterName, $strPos);

                if($currentChapterName != $chapter['name']) {
                    Chapter::where('id', $chapter['id'])->update(['name' => $currentChapterName]);
                }
            }
        }

        return $this->retJson(3, '章节名称格式化成功');
    }

    /**
     * 小说章节排序生成
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/10/21 17:48
     */
    public function chapter_order_recreate(Request $request)
    {
        $bookId = intval($request->input('book_id'));

        if(empty($bookId)) {
            return $this->retJson(3, '数据异常');
        }

        $chapterList = Chapter::where('book_id', $bookId)->get();

        if(empty($chapterList)) {
            return $this->retJson(2, '章节排序格式化失败');
        }

        foreach($chapterList as $chapter)
        {
            $result1 = preg_match('/第([\s\S]*?)章/', $chapter['name'], $match);

            if($result1) {
                $chapterOrder = cn2num($match[1]);

                Chapter::where('id', $chapter['id'])->update(['sort' => $chapterOrder]);
            }
        }

        return $this->retJson(3, '章节排序生成成功');


    }

    /**
     * 小说章节内容
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/10 21:40
     */
    public function book_chapter_content(Request $request)
    {
        $dbId = $request->input('db_id');

        if(empty($dbId)) {
            abort(404);
        }

        $manager = new \MongoDB\Driver\Manager("mongodb://" . config('site.mongodb_ip') . ":". config('site.mongodb_port') ."");

        $filter = ['_id' => new \MongoDB\BSON\ObjectID($dbId)];

        $options = [];

        $query = new \MongoDB\Driver\Query($filter, $options);
        $cursor = $manager->executeQuery('book.chapter', $query);

        $new_cursor = $cursor->toArray();

        if(empty($new_cursor)) {
            abort(404);
        }

        $chapterContent = $new_cursor[0]->content;

        $chapterRow = Chapter::where('db_id', $dbId)->first()->toArray();

        return view('', ['chapterContent' => $chapterContent, 'chapterRow' => $chapterRow]);
    }

    /**
     * 章节添加和修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/10 15:50
     */
    public function book_chapter_save(Request $request)
    {
        $chapterRow = $request->input();

        if(! empty($chapterRow['id'])) {
            Chapter::where('id', $chapterRow['id'])->update($chapterRow);
        }else {
            Chapter::create($chapterRow);
        }

        return $this->retJson(3, '操作成功');
    }

    /**
     * 章节删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/10 15:50
     */
    public function book_chapter_del(Request $request)
    {
        $chapterId = intval($request->input('id'));

        if(empty($chapterId)) {
            return $this->retJson(2, '删除失败');
        }

        Chapter::where('id', $chapterId)->delete();

        return $this->retJson(3, '删除成功');
    }

    /**
     * 小说阅读类型列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/10 00:17
     */
    public function book_reader_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $bookReaderList = BookReader::all();

            return $this->retJsonTableData($bookReaderList);
        }else
        {
            return view('');
        }
    }

    /**
     * 添加和修改小说阅读类型
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/10 00:18
     */
    public function book_reader_save(Request $request)
    {
        $readerRow = $request->input();

        if(! empty($readerRow['id'])) {
            BookReader::where('id', $readerRow['id'])->update($readerRow);
        }else {
            BookReader::create($readerRow);
        }


        Cache::forever('book_reader_list', BookReader::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '操作成功');
    }

    /**
     * 小说阅读类型删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/10 00:19
     */
    public function book_reader_del(Request $request)
    {
        $readerId = intval($request->input('id'));

        if(empty($readerId)) {
            return $this->retJson(2, '删除失败');
        }

        BookReader::where('id', $readerId)->delete();

        Cache::forever('book_reader_list', BookReader::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '删除成功');
    }

    /**
     * 小说类型列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/10 09:50
     */
    public function book_type_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $bookTypeList = BookType::all();

            return $this->retJsonTableData($bookTypeList);
        }else
        {
            return view('');
        }
    }

    /**
     * 小说类型添加和修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/10 09:50
     */
    public function book_type_save(Request $request)
    {
        $typeRow = $request->input();

        if(! empty($typeRow['id'])) {
            BookType::where('id', $typeRow['id'])->update($typeRow);
        }else {
            BookType::create($typeRow);
        }

        Cache::forever('book_type_list', BookType::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '操作成功');
    }

    /**
     * 小说类型删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/10 09:51
     */
    public function book_type_del(Request $request)
    {
        $typeRow = $request->input();

        if(empty($typeRow['id'])) {
            return $this->retJson(2, '删除失败');
        }

        BookType::where('id', $typeRow)->delete();

        Cache::forever('book_type_list', BookType::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '删除成功');
    }
}
