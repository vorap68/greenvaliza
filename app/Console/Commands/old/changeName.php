<?php
namespace App\Console\Commands\old;

use App\Models\Images\Images;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class changeName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:foldername';

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
        // DB::table('images')->update([
        //     'filethumb' => DB::raw("REPLACE(filethumb, '/storage/images/travel/table/', '/storage/images/travelTable/')"),
        // ]);

        DB::table('images')->update([
    'filethumb' => DB::raw("REPLACE(filethumb, '_400.', '_600.')")
]);
     
      //  $images = Images::select('id','filename')->get();
      //    foreach($images as $image){
      //   $fullName = pathinfo($image->filename);
      //   $newname = $fullName['filename'] . '_150.' . $fullName['extension'];
      //         DB::table('images')->where('id',$image->id)->update(['filethumb'=> $newname]);
      }
      
   
    
}
