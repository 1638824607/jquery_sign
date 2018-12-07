<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use Illuminate\Console\Command;

class bookTodayRecommend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_today_recommend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '今日推荐';

    protected $rankName = 'book_today_recommend';

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
        $bookList = Book::where('status', 2)->orderBy('created_at', 'DESC')->limit(10)->get()->toArray();

        $bookJsonList = json_encode($bookList);

        $insertData = [
            'content'   => $bookJsonList
        ];

        BookRank::updateOrCreate(
            ['rank_name' => $this->rankName],
            $insertData
        );
    }
}
