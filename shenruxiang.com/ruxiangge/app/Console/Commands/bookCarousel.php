<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class bookCarousel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_carousel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '轮播图';

    protected $rankName = 'book_carousel';

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
        # web轮播图
        $bookList = Book::where('status', 2)->orderBy(DB::raw('RAND()'))->limit(5)->get()->toArray();

        $bookJsonList = json_encode($bookList);

        $insertData = [
            'content'   => $bookJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => 'book_carousel_web'],
            $insertData
        );

        # wap轮播图
        $bookManList = Book::where('status', 2)->where('reader_type', 1)->orderBy(DB::raw('RAND()'))->limit(3)->get()->toArray();

        $bookManJsonList = json_encode($bookManList);

        $insertData = [
            'content'   => $bookManJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => 'book_carousel_wap_man'],
            $insertData
        );

        $bookWonmanList = Book::where('status', 2)->where('reader_type', 2)->orderBy(DB::raw('RAND()'))->limit(3)->get()->toArray();

        $bookWonmanJsonList = json_encode($bookWonmanList);

        $insertData = [
            'content'   => $bookWonmanJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => 'book_carousel_wap_woman'],
            $insertData
        );

        return TRUE;
    }
}
