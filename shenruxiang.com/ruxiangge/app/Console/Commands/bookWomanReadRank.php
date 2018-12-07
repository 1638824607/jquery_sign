<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class bookWomanReadRank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * 1 日榜 2 周榜 3 月榜
     */
    protected $signature = 'command:book_woman_read_rank {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '女生榜（日周月更新）';

    protected $rankNameList = [
        1 => 'book_woman_read_day_rank',
        2 => 'book_woman_read_week_rank',
        3 => 'book_woman_read_month_rank',
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

        $bookWomanReadRankJsonList = [];

        $bookWomanReadRankName = empty($this->rankNameList[$rankType]) ? '' : $this->rankNameList[$rankType];

        if(empty($bookWomanReadRankName)) {
            return FALSE;
        }

        # 获取redis有序集合 排序
        $bookWomanReadRankList = Redis::zrevrange($bookWomanReadRankName, 0, 9);

        $bookWoamnReadDayRankCount = count($bookWomanReadRankList);

        if($bookWoamnReadDayRankCount < 10)
        {
            $needCount = 10 - $bookWoamnReadDayRankCount;

            $bookList = Book::where('status', 2)->where('reader_type', 2)->orderBy(DB::raw('RAND()'))
                ->take($needCount)
                ->get()->toArray();

            $bookIdArr = arrayColumns($bookList, 'id');

            $bookWomanReadRankList = array_merge($bookWomanReadRankList, $bookIdArr);
        }

        foreach($bookWomanReadRankList as $bookId)
        {
            $bookRow = Book::where('id', $bookId)->first()->toArray();

            $bookArr = [
                'id'          => $bookRow['id'],
                'name'        => $bookRow['name'],
                'author_name' => $bookRow['author_name'],
                'description' => $bookRow['description'],
                'cover'       => $bookRow['cover'],
            ];

            array_push($bookWomanReadRankJsonList, $bookArr);
        }

        $bookWomanReadRankJsonList = json_encode($bookWomanReadRankJsonList);

        $insertData = [
            'rank_name' => $bookWomanReadRankName,
            'content'   => $bookWomanReadRankJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => $bookWomanReadRankName],
            $insertData
        );
    }
}
