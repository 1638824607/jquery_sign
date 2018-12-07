<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use App\Admin\BookType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class bookCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '小说分类排行榜';

    protected $rankName = 'book_category';

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
        # 现代都市
        $bookList[1] = Book::where('status', 2)->where('type', 1)->orderBy(DB::raw('RAND()'))
            ->take(6)
            ->get()->toArray();

        # 玄幻奇幻
        $bookList[3] = Book::where('status', 2)->where('type', 3)->orderBy(DB::raw('RAND()'))
            ->take(6)
            ->get()->toArray();

        # 武侠仙侠
        $bookList[4] = Book::where('status', 2)->where('type', 4)->orderBy(DB::raw('RAND()'))
            ->take(6)
            ->get()->toArray();

        # 女频言情
        $bookList[5] = Book::where('status', 2)->where('type', 5)->orderBy(DB::raw('RAND()'))
            ->take(6)
            ->get()->toArray();

        # 历史军事
        $bookList[6] = Book::where('status', 2)->where('type', 6)->orderBy(DB::raw('RAND()'))
            ->take(6)
            ->get()->toArray();

        # 游戏竞技
        $bookList[7] = Book::where('status', 2)->where('type', 7)->orderBy(DB::raw('RAND()'))
            ->take(6)
            ->get()->toArray();

        # 科幻灵异
        $bookList[8] = Book::where('status', 2)->where('type', 8)->orderBy(DB::raw('RAND()'))
            ->take(6)
            ->get()->toArray();

        $insertData = [
            'rank_name' => $this->rankName,
            'content'   => json_encode($bookList)
        ];

        BookRank::updateOrCreate(
            ['rank_name' => $this->rankName],
            $insertData
        );
    }
}
