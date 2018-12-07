<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class bookReadRank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * 1 日榜 2 周榜 3 月榜
     */
    protected $signature = 'command:book_read_rank {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '热文榜（日周月更新）';

    protected $rankNameList = [
        1 => 'book_read_day_rank',
        2 => 'book_read_week_rank',
        3 => 'book_read_month_rank',
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

        $bookReadRankJsonList = [];

        $bookReadRankName = empty($this->rankNameList[$rankType]) ? '' : $this->rankNameList[$rankType];

        if(empty($bookReadRankName)) {
            return FALSE;
        }

        # 获取redis有序集合 排序
        $bookReadRankList = Redis::zrevrange($bookReadRankName, 0, 9);

        $bookReadDayRankCount = count($bookReadRankList);

        if($bookReadDayRankCount < 10)
        {
            $needCount = 10 - $bookReadDayRankCount;

            $bookList = Book::where('status', 2)->orderBy(DB::raw('RAND()'))
                ->take($needCount)
                ->get()->toArray();

            $bookIdArr = arrayColumns($bookList, 'id');

            $bookReadRankList = array_merge($bookReadRankList, $bookIdArr);
        }

        foreach($bookReadRankList as $bookId)
        {
            $bookRow = Book::where('id', $bookId)->first()->toArray();

            $bookArr = [
                'id'          => $bookRow['id'],
                'name'        => $bookRow['name'],
                'author_name' => $bookRow['author_name'],
                'description' => $bookRow['description'],
                'cover'       => $bookRow['cover'],
                'type'        => $bookRow['type'],
            ];

            array_push($bookReadRankJsonList, $bookArr);
        }

        $bookReadRankJsonList = json_encode($bookReadRankJsonList);

        $insertData = [
            'rank_name' => $bookReadRankName,
            'content'   => $bookReadRankJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => $bookReadRankName],
            $insertData
        );
    }
}
