<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class bookSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_search {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '小说热搜';

    protected $rankName = 'book_search';

    protected $typeName = [
        1 => '网友热搜',
        2 => '24小时热搜',
        3 => '搜索页面推荐',
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
        $type = $this->argument('type');

        $bookList = [];

        # 网友热搜
        if($type == 1) {
            $bookList = Book::where('status', 2)->orderBy('collect_num', 'DESC')->orderBy('read_num', 'DESC')->limit(5)
                ->get()->toArray();
        }
        # 24小时热搜
        elseif($type ==2) {
            $bookList = Book::where('status', 2)->orderBy(DB::raw('RAND()'))->limit(10)->get()->toArray();
        }
        # 搜索页面推荐
        elseif($type ==3) {
            $bookList = Book::where('status', 2)->orderBy(DB::raw('RAND()'))->limit(5)->get()->toArray();
        }

        $bookJsonList = json_encode($bookList);

        $insertData = [
            'content'   => $bookJsonList
        ];

        $rankName = $this->rankName . '_' . $type;

        BookRank::updateOrCreate(
            ['rank_name' => $rankName],
            $insertData
        );
    }
}
