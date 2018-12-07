<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class bookSexRecommend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * # 1 男 2 女
     */
    protected $signature = 'command:book_sex_recommend {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '男生女生当家（性别小说推荐）';

    protected $rankName = 'book_sex_recommend';

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
        $readType = $this->argument('type');

        $bookList = Book::where('status', 2)->where('reader_type', $readType)->orderBy(DB::raw('RAND()'))
            ->take(20)
            ->get()->toArray();


        $bookSexRecommendList = $bookSexRecommendSingleList = [];

        foreach($bookList as $key => $bookRow)
        {
            $bookRow['child'] = [];

            if($key % 9 > 0) {
                array_push($bookSexRecommendSingleList['child'], $bookRow);
            }else{
                if($key != 0) {
                    array_push($bookSexRecommendList, $bookSexRecommendSingleList);
                }

                $bookSexRecommendSingleList = $bookRow;
            }
        }

        $bookJsonList = json_encode($bookSexRecommendList);

        $insertData = [
            'content'   => $bookJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => $this->rankName.'_'.$readType],
            $insertData
        );
    }
}
