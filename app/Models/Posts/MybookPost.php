<?php
namespace App\Models\Posts;

use App\Models\Categories\MyBookMenu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MybookPost extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     */
    protected $table = 'mybook_posts';

    protected $fillable = [
        'title',
        'content',
        'is_visual',
        'description',
        'slug',
        'menu_id',

    ];

    /**
     * Get the mybook menu associated with the mybook post.
     */
    public function mybookMenu()
    {
        return $this->belongsTo(MyBookMenu::class, 'menu_id');
    }
}
