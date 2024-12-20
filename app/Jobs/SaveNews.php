<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SaveNews implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public NewsDTO $newsDTO)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        News::save($this->newsDTO);
    }
}
