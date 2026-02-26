<?php
namespace App\Http\Controllers\Admin\ChangeTitle;

use Illuminate\Http\Request;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use App\Services\ChangeTitleAllCatService;
use App\Services\ChangeTitleTravelService;

class TitleTravelController 
{

    protected $serviceAllCat;
    protected $serviceTravelCat;

    public function __construct(ChangeTitleTravelService $serviceTravelCat) {
       $this->serviceTravelCat = $serviceTravelCat;
    }


    
    public function updateTravelPostSingle($id, Request $request)
    {
        $newTitle  = $request->input('title');
        $singlePost = TravelPost::with('travelMenu')->find($id);
       // return response()->json(['post' => $singlePost]);
        $result    = $this->serviceTravelCat->changeTitlePostSingle($singlePost, $newTitle);

        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);

    }

    public function updateTravelPostFinal($id, Request $request)
    {
       $newTitle = $request->input('title');
        $finalPost = TravelPost::find($id);
         //return response()->json(['post' => $finalPost]);
        $result    = $this->serviceTravelCat->changeTitlePostFinal($finalPost, $newTitle);

        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);

    }

    public function updateTravelTable($id, Request $request)
    {
        $newTitle = $request->input('title');
        $tablePost     = TravelTable::with('travelMenu')->find($id);
       // return response()->json(['post' => $table]);
        $result    = $this->serviceTravelCat->changeTitleTable($tablePost, $newTitle);

        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);

    }
}
