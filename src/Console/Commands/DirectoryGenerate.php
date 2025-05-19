<?php

namespace Uzinfocom\Dastyor\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DirectoryGenerate extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create directory description';

    /**
     * Execute the console command.
     */
    public function handle(): void {
        $folders = [
                'app/Services',
                'app/Http/Requests',
                'app/Http/Resources',
        ];

        foreach ($folders as $folder) {
            File::makeDirectory($folder, 0777, true, true);
        }

        $this->info('Folders generated successfully.');
    }
}
