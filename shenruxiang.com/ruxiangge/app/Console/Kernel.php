<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        # 小说分类排行榜
        $schedule->command('command:book_category')->weekly();

        # 小说收藏榜
        $schedule->command('command:book_collect')->weekly();

        # 当红文
        $schedule->command('command:book_hot')->weekly();

        # 男生榜（日周月更新）
        $schedule->command('command:book_man_read_rank 1')->daily();   # 日
        $schedule->command('command:book_man_read_rank 2')->weekly();  # 周
        $schedule->command('command:book_man_read_rank 3')->monthly(); # 月

        # 女生榜（日周月更新）
        $schedule->command('command:book_woman_read_rank 1')->daily();   # 日
        $schedule->command('command:book_woman_read_rank 2')->weekly();  # 周
        $schedule->command('command:book_woman_read_rank 3')->monthly(); # 月

        # 热文榜（日周月更新）
        $schedule->command('command:book_read_rank 1')->daily();   # 日
        $schedule->command('command:book_read_rank 2')->weekly();  # 周
        $schedule->command('command:book_read_rank 3')->monthly(); # 月

        # 主编力推榜
        $schedule->command('command:book_recommend')->weekly();

        # 今日推荐
        $schedule->command('command:book_today_recommend')->daily();

        # 男生女生当家（性别小说推荐）
        $schedule->command('command:book_sex_recommend 1')->weekly();
        $schedule->command('command:book_sex_recommend 2')->weekly();

        # 小说更新列表
        $schedule->command('command:book_update')->daily();

        # 小说实时收藏
        $schedule->command('command:book_update_collect')->daily();

        # 网友热搜
        $schedule->command('command:book_search 1')->weekly();

        # 24小时热搜
        $schedule->command('command:book_search 2')->daily();

        # 搜索页面推荐
        $schedule->command('command:book_search 3')->weekly();

        # 轮播图
        $schedule->command('command:book_carousel')->weekly();

        # wap男女分版小说推荐
        $schedule->command('command:book_wap_sex_recommend')->weekly();

        # 爬虫每天定时爬取
        $schedule->command('command:book_scrapy')->dailyAt('20:00');

        # wap H5页面每周推荐
        $schedule->command('command:book_wap_recommend')->weekly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
