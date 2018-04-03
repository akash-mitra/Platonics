<?php
namespace App\Http\Controllers\API\v1;

use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\PaginateTransformer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class APIMediaController extends Controller
{

    /**
     * Maps a database field name to a given label name
     *
     * @var array
     */
    protected $field_mapper = [
        'id' => 'unique_id',
        'url'  => 'path',
        'updated_at' => 'last_modified',
        'size_kb' => 'size_in_kb',
        'storage' => 'storage'
    ];



    /**
     * Returns a JSON response containing a paginated
     * list of all media.
     *
     * @return Illuminate\Http\JsonResponse
     */
    protected function getMedia(PaginateTransformer $t)
    {
        try {
            $media = Media::paginate(20);
            $transformedData = $t->transform($media, $this->field_mapper);
            return response()->json($transformedData);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json('Generic Exception in Server', 500);
        }
    }
}
