<?php

namespace App\Http\Controllers;

use Auth;
use App\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function __construct()
    {
    	// only posting of comments require logging in
    	return $this->middleware('auth')->only('store');
    }


    /**
     * This function returns JSON for all the comments made
     * by a particular user identified by the $slug
     */
    public function commentsByUser ($slug)
    {
    	if (empty($slug)) abort(404);
    	$comments = Comment::byUser($slug)->get();
    	return $this->jsonifyResponse($comments);
    }


    /**
     * This function returns JSON for all the comments made
     * on a particular page/article identified by $id
     */
    public function commentsByPage ($id)
    {
    	if (empty($id)) abort(404);
    	$comments = Comment::onPage($id)->get();
    	return $this->jsonifyResponse($comments);
    }


    /**
     * Stores the comment to database
     */
    public function store(Request $request)
    {

    	$text = $request->input('text');
    	$user = Auth::user()->id;
    	$page = $request->input('pageid');

    	// if mandatory information for a comment
    	// were not provided, return error
    	if (empty($text) || empty($user) || empty($page))
    		return response()->json([
    			'status' => 'failure', 
    			'message' => 'invalid comment parameters'
    			], 422);


    	$comment = new Comment(['body' => $text, 'user_id' => $user, 'page_id' => $page]);
    	$comment->save();

    	return response()->json(['status' => 'success','action' => 'save', 'message' => 'Comment saved successfully']);
    }


    /**
     * A handy function to separate out the 
     * explicit creation of JSON response
     */
    private function jsonifyResponse($comments)
    {
    	return response()->json($this->mapper($comments));
    }


    /**
     * This function converts a database response (received
     * from the Model as Collection) to a JSON array of 
     * objects containing relevant information about
     * comment, page and the user who made the comments
     */
    private function mapper ($comments) {

    		return $comments->map(function ($comment) {
    			return [
    			// perform some HTML escaping before displaying the untrusted strings
                'text' => $this->noHTML($comment->body),
    			'when' => Carbon::parse($comment->created_at)->diffForHumans(),
    			'user' => [
    				'name' => $this->noHTML($comment->name),
    				'profile' => route('user', $comment->slug),
    				'avatar' => $comment->avatar,
    			],
    			'page' => [
    				'title' => $this->noHTML($comment->title),
    				'url' => '/' 
    					. (empty($comment->category)? 'general':$comment->category)
    					. '/' 
    					. str_slug ($comment->id . ' ' . $comment->title),
    			]
    		];
    	});
    }


    private function noHTML($input, $encoding = 'UTF-8')
    {
        // return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
        return htmlentities($input, ENT_QUOTES, $encoding);
    }

    // end of class
}
