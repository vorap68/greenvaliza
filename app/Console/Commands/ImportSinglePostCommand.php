<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\ImportSinglePost;




class ImportSinglePostCommand extends Command
{
   
    protected $signature = 'import:singlepost {postId} ';

  
    protected $description = 'Import a single post from greenvaliza';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $postId      = $this->argument('postId');
        
    
      $importer = new ImportSinglePost();
        $posts    = $importer->getPost($postId);    
    }
}
