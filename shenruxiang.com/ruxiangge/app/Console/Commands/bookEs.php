<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use Illuminate\Console\Command;

class bookEs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_es';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'es搜索小说更新';

    protected $rankName = 'book_es';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        require 'vendor/autoload.php';
        $client = \Elasticsearch\ClientBuilder::create()->build();

        $deleteParams = [
            'index' => 'book'
        ];
        $response = $client->indices()->delete($deleteParams);

        $bookList = Book::where('status', 2)->get()->toArray();

        $params = [];

        foreach($bookList as $bookRow)
        {
            $params['body'][] = [
                'index' => [
                    '_index' => 'book',
                    '_type' => 'book',
                ]
            ];

            $params['body'][] = [
                'book_id'         => $bookRow['id'],
                'book_name'       => $bookRow['name'],
                'book_cover'      => $bookRow['cover'],
                'book_desc'       => $bookRow['description'],
                'author_name'     => $bookRow['author_name'],
                'cate_name'       => $bookRow['type'],
                'book_word_count' => $bookRow['word_count'],
                'update_time'     => $bookRow['updated_at'],
            ];
        }

        $response = $client->bulk($params);

        return  TRUE;

    }
}
