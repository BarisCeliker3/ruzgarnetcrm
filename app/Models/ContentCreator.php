namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentCreator extends Model
{
    protected $fillable = ['title', 'content', 'image_url'];
}