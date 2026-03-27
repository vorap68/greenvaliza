<?php

namespace App\Console\Commands;

use App\Models\Categories\TravelMenu;
use App\Models\Posts\TravelTable;
use Illuminate\Console\Command;

class InsertTermIdInTraveTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert_term_id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert term_id into travel table From TravelMenu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $termIds = TravelMenu::pluck('term_id', 'slug')->toArray();
        $travel_tables = TravelTable::all();

        foreach ($travel_tables as $travel_table) {
            $slug = $travel_table->slug;
            if (isset($termIds[$slug])) {
                $travel_table->term_id = $termIds[$slug];
                $travel_table->save();
            }
        }

     
        $this->info('Term ID insertion completed successfully.');
    }
}
