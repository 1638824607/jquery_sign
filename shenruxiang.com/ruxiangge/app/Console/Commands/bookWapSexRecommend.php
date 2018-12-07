<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class bookWapSexRecommend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_wap_sex_recommend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '男女生小说推荐';

    protected $rankName = 'book_wap_sex_recommend';

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
        # 男生精品
        $bookManList = Book::where('status', 2)->where('reader_type', 1)->orderBy(DB::raw('RAND()'))->limit(5)->get()->toArray();

        $bookManJsonList = json_encode($bookManList);

        $insertData = [
            'content'   => $bookManJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => 'book_wap_man_1'],
            $insertData
        );

        # 热血爽文
        $bookManList = Book::where('status', 2)->where('reader_type', 1)->orderBy(DB::raw('RAND()'))->limit(5)->get()->toArray();

        $bookManJsonList = json_encode($bookManList);

        $insertData = [
            'content'   => $bookManJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => 'book_wap_man_2'],
            $insertData
        );


        # 女生佳作
        $bookWomanList = Book::where('status', 2)->where('reader_type', 2)->orderBy(DB::raw('RAND()'))->limit(5)->get()->toArray();

        $bookWomanJsonList = json_encode($bookWomanList);

        $insertData = [
            'content'   => $bookWomanJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => 'book_wap_woman_1'],
            $insertData
        );

        # 精选热文
        $bookWomanList = Book::where('status', 2)->where('reader_type', 2)->orderBy(DB::raw('RAND()'))->limit(5)->get()->toArray();

        $bookWomanJsonList = json_encode($bookWomanList);

        $insertData = [
            'content'   => $bookWomanJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => 'book_wap_woman_2'],
            $insertData
        );

        return TRUE;
    }
}
