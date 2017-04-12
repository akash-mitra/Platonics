<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * This is a helper function to query only the attributes
     * required in this view. This helps in avoiding selection
     * of large text columns and clog up memory
     */
    private function list ()
    {
        return DB::select('select a.id, a.title, a.created_at, a.updated_at, u.name author, c.name category 
            from articles a 
            left outer join users u on a.user_id = u.id 
            left outer join categories c on a.category_id = c.id
            order by a.updated_at desc');
    }

    protected function index ()
    {
    	$articles = $this->list();
    	return view ('article.index', compact('articles'));
    }

    protected function show ($slug)
    {
    	// The Id is determined by cutting the slug from the
    	// beginning to the first occurance of "-" sign.
    	// Because sometimes "-" might not appear in  
    	// the slug, we append extra "-" with it.
    	$id = substr($slug, 0, strpos($slug . '-', '-'));

    	$article = Article::findOrFail($id);
    	if ($article->publish == '1')
    	   return view ('article.show', compact('article'));

        abort(404, 'Page Not Published');
    }


    protected function create ()
    {
    	return view ('article.create');
    }

    protected function store (Request $request)
    {
    	$doc = new Article ([
    		'title'       => $request->input('head'),
    		'intro'       => $request->input('summary'),
            'category_id' => $request->input('cat'),
    		'fulltext'    => $request->input('body'),
    		'metakey'     => $request->input('keys'),
    		'metadesc'    => $request->input('desc'),
            'publish'     => $request->has('publish') ? 1 : 0
    	]);

    	$article = Auth::user()->articles()->save($doc);
    	
    	return redirect()
    		->route('article-edit', $article->id)
    		->withMessage('Article saved');
    }


    protected function edit ($id)
    {
        $article = Article::findOrFail($id);
        return view ('article.edit', compact('article'));
    }


    protected function save (Request $request)
    {
        $id = $request->input('id');
        $article = Article::findOrFail($id);
        
        $article->title         = $request->input('head');
        $article->intro         = $request->input('summary');
        $article->category_id   = $request->input('cat');
        $article->fulltext      = $request->input('body'); 
        $article->metakey       = $request->input('keys');
        $article->metadesc      = $request->input('desc');
        $article->publish       = $request->has('publish') ? 1 : 0;

        $article->save();
        
        return redirect()
            ->route('article-edit', $id)
            ->withMessage('Article saved');
    }

    protected function destroy ($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()
            ->route('article-index')
            ->withMessage('Article saved');
    }
}
