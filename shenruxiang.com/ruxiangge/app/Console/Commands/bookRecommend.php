<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use App\Admin\BookType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class bookRecommend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_recommend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '主编力推榜';

    protected $rankName = 'book_recommend';

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
        # 获取小说列表
        $bookList = Book::where('status', 2)->orderBy(DB::raw('RAND()'))
            ->take(18)
            ->get()->toArray();

        # 获取小说类型
        $bookTypeList = BookType::where('status', 1)->get()->keyBy('id')->toArray();

        $bookRecommendList = $bookRecommendSingleList = [];

        foreach($bookList as $key => $bookRow)
        {
            $bookRecommend = [
                'id'          => $bookRow['id'],
                'name'        => $bookRow['name'],
                'author_name' => $bookRow['author_name'],
                'description' => $bookRow['description'],
                'cover'       => $bookRow['cover'],
                'type'        => $bookTypeList[$bookRow['type']]['name'],
                'child'       => []
            ];

            if($key % 5 > 0) {
                array_push($bookRecommendSingleList['child'], $bookRecommend);
            }else{
                if($key != 0) {
                    array_push($bookRecommendList, $bookRecommendSingleList);
                }

                $bookRecommendSingleList = $bookRecommend;
            }
        }

        $insertData = [
            'rank_name' => $this->rankName,
            'content'   => json_encode($bookRecommendList)
        ];

        BookRank::updateOrCreate(
            ['rank_name' => $this->rankName],
            $insertData
        );
    }
}
