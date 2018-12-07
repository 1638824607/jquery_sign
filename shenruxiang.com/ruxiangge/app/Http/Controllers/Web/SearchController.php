<?php

namespace App\Http\Controllers\Web;

use App\Admin\BookRank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SearchController extends BaseController
{
    public function index($content = '')
    {
        require '../vendor/autoload.php';
        $client = \Elasticsearch\ClientBuilder::create()->build();

        $searchContent = trim($content);

        $searchList = [];

        if(! empty($searchContent))
        {
            try {
                $params = [
                    'index' => 'book',
                    'type'  => 'book',
                    'size'  => 100,
                    'body'  => [
                        'query' => [
                            'match_phrase' => [
                                'book_name' => $searchContent
                            ]
                        ],
                        'highlight' => [
                            'fields' => [
                                'book_name' => new \stdClass()
                            ]
                        ]
                    ]
                ];

                $searchList = $client->search($params);

            } catch (\Exception $e) {
                abort(404);
            }

        }

        $bookSearchRow  = BookRank::where('rank_name', 'book_search_3')->first()->toArray();
        $bookSearchList = json_decode($bookSearchRow['content'], true);

        return view('', [
            'searchList'     => $searchList,
            'searchContent'  => $searchContent,
            'bookSearchList' => $bookSearchList,
        ]);
    }
}
