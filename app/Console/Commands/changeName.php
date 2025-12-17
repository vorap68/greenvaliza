<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Images\GuidePostImage;

class changeName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $guides = GuidePostImage::all();
        foreach ($guides as $guide) {
           $old = $guide->filename;
          // dd($old);
              $new = str_replace('guidebooks/', 'guide/', $old);
              $guide->filename = $new;
              $guide->save();
        }
    }
}
