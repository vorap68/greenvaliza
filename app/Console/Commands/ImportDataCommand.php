<?php
namespace App\Console\Commands;

use App\Components\ImportData;
use App\Components\ImportPost;
use Illuminate\Console\Command;

class ImportDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import posts from greenvaliza';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $importer = new ImportPost();
        $posts    = $importer->getPosts(20, 1);
     

    }
}
