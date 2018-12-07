<?php

namespace App\Console\Commands;

use App\Admin\Book;
use App\Admin\BookRank;
use App\Admin\ReptileLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class bookScrapy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book_scrapy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '小说每天爬取';

    protected $rankName = 'book_scrapy';

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
        $reptileLog = ReptileLog::create([
            'reptile_id' => 0,
            'target_url' => 'http://www.quanbenwu.com',
            'start_time' => date('Y-m-d H:i:s', time()),
        ]);

        $reptileId = $reptileLog->id;

        $pythonReptileShell = 'cd /home/wwwroot/default/book_reptile && /usr/local/bin/scrapy crawl book_update  -s LOG_FILE=all.log  -a reptile_id='.$reptileId;

        $commend = $pythonReptileShell . ' > /dev/null 2>&1';

        @exec($commend);

        return TRUE;
    }
}
