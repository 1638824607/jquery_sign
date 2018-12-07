<?php

namespace App\Http\Controllers\Wap;

use App\Admin\Book;
use App\Admin\BookRank;
use App\Http\Controllers\Api\ZhuishuController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class SearchController extends BaseController
{
    /**
     * 搜索页面
     * @param string $content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/12 21:04
     */
    public function inside_search($content = '')
    {
        $bookSearchRow  = BookRank::where('rank_name', 'book_search_3')->first()->toArray();
        $bookSearchList = json_decode($bookSearchRow['content'], true);

        $searchHistoryList = [];

        if(isset($_COOKIE['search_history'])) {
            $searchHistoryList = json_decode($_COOKIE['search_history']);
        }

        return view('', [
            'bookSearchList'    => $bookSearchList,
            'searchHistoryList' => $searchHistoryList
        ]);
    }

    /**
     * 搜索列表
     * @param string $content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/12 21:05
     */
    public function inside_search_list($content = '')
    {
//        require '../vendor/autoload.php';
//        $client = \Elasticsearch\ClientBuilder::create()->build();

        $searchContent = trim($content);

        $searchList = [];

        if(! empty($searchContent))
        {
            $searchHistoryList = [];

            if(isset($_COOKIE['search_history'])) {
                $searchHistoryList = json_decode($_COOKIE['search_history']);

                if(count($searchHistoryList) > 6) {
                    array_shift($searchHistoryList);
                }
            }

            if(! in_array($searchContent, $searchHistoryList)) {
                array_push($searchHistoryList, $searchContent);
            }

            setcookie("search_history", json_encode($searchHistoryList), time() + 365 * 24 * 60 * 60, '/');


            $searchList = Book::where('name', 'like', '%'.$content.'%')->get()->toArray();

//            try {
//                $params = [
//                    'index' => 'book',
//                    'type'  => 'book',
//                    'size'  => 100,
//                    'body'  => [
//                        'query' => [
//                            'match_phrase' => [
//                                'book_name' => $searchContent
//                            ]
//                        ],
//                        'highlight' => [
//                            'fields' => [
//                                'book_name' => new \stdClass()
//                            ]
//                        ]
//                    ]
//                ];
//
//                $searchList = $client->search($params);
//
//            } catch (\Exception $e) {
//                abort(404);
//            }

        }

        return view('', [
            'searchList'     => $searchList,
            'searchContent'  => $searchContent,
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

    public function del_search_history()
    {
        setcookie("search_history");


        return $this->retJson(2, 'success');
    }
}
