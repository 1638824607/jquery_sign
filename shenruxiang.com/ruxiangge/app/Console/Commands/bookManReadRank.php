<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class bookManReadRank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * 1 日榜 2 周榜 3 月榜
     */
    protected $signature = 'command:book_man_read_rank {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '男生榜（日周月更新）';

    protected $rankNameList = [
        1 => 'book_man_read_day_rank',
        2 => 'book_man_read_week_rank',
        3 => 'book_man_read_month_rank',
    ];

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
        $rankType = $this->argument('type');

        $bookManReadRankJsonList = [];

        $bookManReadRankName = empty($this->rankNameList[$rankType]) ? '' : $this->rankNameList[$rankType];

        if(empty($bookManReadRankName)) {
            return FALSE;
        }

        # 获取redis有序集合 排序
        $bookManReadRankList = Redis::zrevrange($bookManReadRankName, 0, 9);

        $bookWoamnReadDayRankCount = count($bookManReadRankList);

        if($bookWoamnReadDayRankCount < 10)
        {
            $needCount = 10 - $bookWoamnReadDayRankCount;

            $bookList = Book::where('status', 2)->where('reader_type', 2)->orderBy(DB::raw('RAND()'))
                ->take($needCount)
                ->get()->toArray();

            $bookIdArr = arrayColumns($bookList, 'id');

            $bookManReadRankList = array_merge($bookManReadRankList, $bookIdArr);
        }

        foreach($bookManReadRankList as $bookId)
        {
            $bookRow = Book::where('id', $bookId)->first()->toArray();

            $bookArr = [
                'id'          => $bookRow['id'],
                'name'        => $bookRow['name'],
                'author_name' => $bookRow['author_name'],
                'description' => $bookRow['description'],
                'cover'       => $bookRow['cover'],
            ];

            array_push($bookManReadRankJsonList, $bookArr);
        }

        $bookManReadRankJsonList = json_encode($bookManReadRankJsonList);

        $insertData = [
            'rank_name' => $bookManReadRankName,
            'content'   => $bookManReadRankJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => $bookManReadRankName],
            $insertData
        );
    }
}
