<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\ImportCategory;

class ImportCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =  'Import categories from greenvaliza';


    /**
     * Execute the console command.
     */
    public function handle()
    {
         $importer = new ImportCategory();
        $categories  = $importer->getGategories(20, 1);
    }
}
