<?php

namespace App\Http\Controllers;

use App\Page;

class PageController extends BaseController
{
    /**
     * Returns a single article page
     */
    protected function show($categorySlug, $pageSlug)
    {
        // The Id is determined by cutting the slug from the
        // beginning to the first occurance of "-" sign.
        // Because sometimes "-" might not appear in
        // the slug, we append extra "-" with it.
        $id = substr($pageSlug, 0, strpos($pageSlug . '-', '-'));

        $page = Page::findOrFail($id);

        if ($page->category_id === null || $page->category->slug === $categorySlug) {
            return view('page.show', [
                    'page' => $page,
                    'pageMeta' => [
                            'type' => 'article',
                            'page_id' => $id,
                            'category_id' => $page->category_id,
                            'created_at' => $page->created_at,
                            'updated_at' => $page->updated_at
                    ]
                ]);
        }

        abort(404, 'Page Not Found');
    }
}
