<?php

namespace App\Jobs;

use App\Admin\Reptile;
use App\Admin\ReptileLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RunReptile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reptileRow;

    /**
     * Create a new job instance.
     * RunReptile constructor.
     * @param $reptileRow
     */
    public function __construct($reptileRow)
    {
        $this->reptileRow = $reptileRow;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pythonReptileShell = $this->reptileRow['cmd'] . " -a reptile_id={$this->reptileRow['id']} -a start_urls={$this->reptileRow['now_url']}";

        $commend = $pythonReptileShell . ' > /dev/null 2>&1';

        @exec($commend);
    }
}
