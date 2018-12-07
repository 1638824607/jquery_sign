<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use App\Admin\Chapter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class bookUpdateCollect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_update_collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '小说实时收藏';

    protected $rankName = 'book_update_collect';

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
        $bookList = Book::where('status', 2)->orderBy(DB::raw('RAND()'))
            ->limit(20)
            ->get()->toArray();

        $userNameList    = config('random_name');
        $userNameKeyList = array_rand($userNameList, 20);

        foreach($bookList as $key => &$bookRow)
        {
            $bookRow['user_name'] = $userNameList[$userNameKeyList[$key]];
        }

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
