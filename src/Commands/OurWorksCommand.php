<?php

namespace MediaWebId\OurWorks\Commands;

use Illuminate\Console\Command;

class OurWorksCommand extends Command
{
    public $signature = 'ourworks';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
