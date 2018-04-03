<?php

namespace App\Http\Controllers;

use App\Media;
use App\Configuration;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MediaController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }


    public function index()
    {
        $media = Media::paginate(20);
        return view('media.index', compact('media'));
    }



    public function store()
    {
        $uploadedFile      = request()->file('file');
        $maxSizeInMB       = 1;
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'bmp', 'gif'];
        
        try {
            $media = Media::store($uploadedFile, null, $allowedExtensions, $maxSizeInMB);
            return response()->json($media, 200);
        } catch (HttpException $e) {
            return response()->json(["message" => $e->getMessage()], $e->getStatusCode());
        }
    }
}
