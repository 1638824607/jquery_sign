<?php

namespace App\Http\Controllers\Api;

class ZhuishuController extends BaseController
{
    private $zhuiShuUrl = [
        # 分类
        'cate_list' => 'http://api.zhuishushenqi.com/cats/lv2/statistics',
        # 分类下小分类
        'cate_lv'   => 'http://api.zhuishushenqi.com/cats/lv2',
        # 分类下小说
        'cate'      => 'https://api.zhuishushenqi.com/book/by-categories',
        # 小说详情
        'detail'    => 'http://api.zhuishushenqi.com/book/',
        # 作者作品
        'author'    => 'http://api.zhuishushenqi.com/book/accurate-search',
        # 正版源和盗版源
        'atoc'      => 'http://api.zhuishushenqi.com/atoc',
        # 混合源
        'min-atoc'  => 'http://api.zhuishushenqi.com/mix-atoc/',
        # 章节内容
        'content'   => 'http://chapterup.zhuishushenqi.com/chapter/',
        # 搜索热词
        'search_hotwords'  => 'http://api.zhuishushenqi.com/book/search-hotwords',
        # 模糊搜索
        'search_fuzzy'     => 'http://api.zhuishushenqi.com/book/fuzzy-search',
        # 书单列表
        'book_list'        => 'http://api.zhuishushenqi.com/book-list',
        # 书单详情
        'book_list_detail' => 'http://api.zhuishushenqi.com/book-list/',
        # 排行分类
        'book_rank'        => 'http://api.zhuishushenqi.com/ranking/gender',
        # 排行分类详情
        'book_rank_detail' => 'http://api.zhuishushenqi.com/ranking/'
    ];

    /**
     * 分类列表
     * @author shenruxiang
     * @date 2018/11/17 21:25
     */
    public function cate_list()
    {
        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['cate_list']
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function cate_lv()
    {
        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['cate_lv']
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function cate($param)
    {
        $param = is_array($param) ? $param : FALSE;

        if(empty($param)) {
            return [
                'status' => 3,
                'msg'    => 'fail参数空',
            ];
        }

        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['cate'],
                ['query' => $param]
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function detail($bookId)
    {
        $bookId = empty($bookId) ? '' : trim($bookId);

        if(empty($bookId)) {
            return [
                'status' => 3,
                'msg'    => 'fail',
            ];
        }

        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['detail'].$bookId
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function author($authorName)
    {
        $authorName = empty($authorName) ? '' : trim($authorName);

        if(empty($authorName)) {
            return [
                'status' => 3,
                'msg'    => 'fail参数空',
            ];
        }

        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['author'],
                ['query' => ['author' => $authorName]]
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function min_atoc($bookId)
    {
        $bookId = empty($bookId) ? '' : trim($bookId);

        if(empty($bookId)) {
            return [
                'status' => 3,
                'msg'    => 'fail参数空',
            ];
        }

        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['min-atoc'].$bookId,
                ['query' => [
                    'view' => 'chapters',
                ]]
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function content($chapterLink)
    {
        $chapterLink = empty($chapterLink) ? '' : trim($chapterLink);

        if(empty($chapterLink)) {
            return [
                'status' => 3,
                'msg'    => 'fail参数空',
            ];
        }

        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['content'].urlencode($chapterLink)
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function search_hotwords()
    {
        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['search_hotwords']
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function search_fuzzy($search)
    {
        $search = empty($search) ? '' : trim($search);

        if(empty($search)) {
            return [
                'status' => 3,
                'msg'    => 'fail参数空',
            ];
        }

        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['search_fuzzy'],
                ['query' => [
                    'query' => $search,
                ]]
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function book_list($sort = 'collectorCount', $duration = 'all', $gender = 'male', $tag = '', $start = 0)
    {
        # sort collectorCount create
        # duration last-seven-days all
        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['book_list'],
                ['query' => [
                    'sort'     => $sort,
                    'duration' => $duration,
                    'gender'   => $gender,
                    'tag'      => $tag,
                    'start'    => $start,
                ]]
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function book_list_detail($bookListId)
    {
        $bookListId = empty($bookListId) ? '' : $bookListId;

        if(empty($bookListId)) {
            return [
                'status' => 3,
                'msg'    => 'fail',
            ];
        }

        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['book_list_detail'].$bookListId
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function book_rank()
    {
        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['book_rank']
            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

    public function book_rank_detail($bookRankId)
    {
        $bookRankId = empty($bookRankId) ? '' : $bookRankId;

        if(empty($bookRankId)) {
            return [
                'status' => 3,
                'msg'    => 'fail',
            ];
        }

        try {
            $response = $this->guzzleClient()->request(
                'GET',
                $this->zhuiShuUrl['book_rank_detail'].$bookRankId

            );

            $statusCode = $response->getStatusCode();

            if($statusCode == 200) {
                $rsp = $response->getBody()->getContents();

                return [
                    'status' => 2,
                    'msg'    => 'success',
                    'data'   => $rsp
                ];
            }

            return [
                'status' => 3,
                'msg'    => 'fail',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 4,
                'msg'    => 'fail',
                'data'    => $e->getMessage(),
            ];
        }
    }

}