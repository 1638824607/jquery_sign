<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use App\Admin\Chapter;
use Illuminate\Console\Command;

class bookUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '小说更新列表';

    protected $rankName = 'book_update';

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
        $bookList = Book::where('status', 2)->orderBy('created_at', 'DESC')
            ->limit(30)
            ->get()->toArray();

        foreach($bookList as &$bookRow)
        {
            $lastBookChapterRow = Chapter::where('book_id', $bookRow['id'])->orderBy('sort', 'DESC')->first()->toArray();
            $bookRow['last_chapter_name'] = $lastBookChapterRow['name'];
            $bookRow['last_chapter_time'] = date('Y-m-d', strtotime($lastBookChapterRow['created_at']));
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
