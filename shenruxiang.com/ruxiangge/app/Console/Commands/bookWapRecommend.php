<?php

namespace App\Console\Commands;

use App\Admin\Book;
use Illuminate\Console\Command;
use App\Admin\BookRecommend;

class bookWapRecommend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_wap_recommend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'h5每周推荐';

    protected $rankName = 'book_wap_recommend';

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
        sleep(10);

        $startTime = date('Y-m-d H:i:s', strtotime('Sunday -6 day', time()));
        $endTime   = date('Y-m-d H:i:s', time());

        # 获取上周小说列表
        $bookList = Book::where('status', 2)->where('created_at', '>=', $startTime)
            ->where('updated_at', '<=', $endTime)->take(6)->get()->toArray();

        $insertData = [];

        foreach($bookList as $bookRow)
        {
           $tmpData = [
               'book_id'    => $bookRow['id'],
               'start_day'  => date('Y.m.d',strtotime('-6 day', time())),
               'end_day'    => date('Y.m.d',time()),
               'created_at' => date('Y-m-d H:i:s',time()),
               'updated_at' => date('Y-m-d H:i:s',time()),
           ];

            $insertData[] = $tmpData;
        }

        BookRecommend::insert($insertData);

        return TRUE;
    }
}
