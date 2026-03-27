<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetAllTermIdMenuCommand extends Command
{
    use \App\Trait\GetTermMenuId;

    protected $signature = 'get:termid';

    protected $description = 'Получение всех term_id меню  для сохранения в таблице travels_menu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->initClient();
        $terms = $this->getTermMenu(100, 1);
        //dump($terms);
        foreach ($terms as $term) {
            dump($term);
        }

    }
}
