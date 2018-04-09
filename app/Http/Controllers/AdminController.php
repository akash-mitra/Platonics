<?php

namespace App\Http\Controllers;

use App\User;
use App\Page;
use App\Comment;
use App\Category;
use Carbon\Carbon;
use App\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->middleware('admin')->only(['destroyPage', 'deleteComment', 'design']);

        // all other operations, only admin, author, editor has permissions
        $this->middleware(function ($request, $next) {
            if (Auth::user() && in_array(Auth::user()->type, ['Author', 'Editor', 'Admin'])) {
                return $next($request);
            }

            flash('You do not have permission to this page')->warning();

            return redirect('/');
        });

        parent::__construct();
    }

    /**
     * Shows the admin console page
     */
    protected function show()
    {
        $growthData = $this->getDayWiseGrowth();

        $cumGrowthData = $this->getCumulativeGrowth($growthData, ['users', 'pages']);

        $xAxisData = array_map(function ($item) {
            $data['year'] = $item->year;
            $data['month'] = $item->month;
            $data['day'] = $item->day;

            return $data;
        }, $cumGrowthData);

        $yAxisDataPage = array_map(function ($item) {
            return $item->pages;
        }, $cumGrowthData);

        $yAxisDataUser = array_map(function ($item) {
            return $item->users;
        }, $cumGrowthData);

        return view('admin.show', [
            'xData' => $xAxisData,
            'yDataPage' => $yAxisDataPage,
            'yDataUser' => $yAxisDataUser
        ]);
    }

    /**
     * Shows a list of all the users registered to the platform
     */
    protected function users()
    {
        $users = User::get(User::permittedAttributes())->all();

        return view('admin.users')->withUsers($users);
    }

    /**
     * Returns a page containing the list of all articles
     */
    protected function pages()
    {
        $pages = $this->listPages();

        return view('page.index', compact('pages'));
    }

    /**
     * Opens up a blank page editor if id is not provided.
     * If Id is provided, opens up a page editor with the page contents.
     */
    protected function editor($id = null)
    {
        $page = $this->getPageObject($id);

        if (!$this->checkPageActionPermissions('edit', $page)) {
            return redirect()->route('page-index');
        }

        return view('page.editor', compact('page'));
    }

    /**
     * Saves a the contents of the page to the database.
     * If the page does not already exists, then create
     * new page. If the page exists, then update the page.
     */
    protected function savePage(Request $request)
    {
        $page = $this->getPageObject($request->input('id'));

        if (!$this->checkPageActionPermissions('save', $page)) {
            return redirect()->route('page-index');
        }

        $page->fill($request->input());

        try {
            $page = Auth::user()->pages()->save($page);

            return response()->json($page->id, 200);
        } catch (HttpException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            // if there is something still not caught above within HttpException
            // e.g. Internal Server Errors, we want to catch them here.
            return response()->json(['message' => 'Error'], 500);
        }
    }

    /**
     * Deletes the page from the database
     */
    protected function destroyPage($id)
    {
        if (!$this->checkPageActionPermissions('delete')) {
            return redirect()->route('page-index');
        }

        $page = Page::findOrFail($id);
        $page->delete();

        flash('Page deleted successfully')->success();

        return redirect()->route('page-index');
    }

    /**
     * Returns a page containing category listing
     */
    protected function categories()
    {
        $categories = Category::all();

        return view('category.index', compact('categories'));
    }

    /**
     * Shows the create category page
     */
    protected function createCategory()
    {
        if (!$this->checkCategoryActionPermissions('create')) {
            return redirect()->back();
        }

        return view('category.create');
    }

    /**
     * Creates a new category.
     */
    protected function storeCategory(Request $request)
    {
        if (!$this->checkCategoryActionPermissions('store')) {
            return redirect()->back();
        }

        $doc = new Category([
            'name' => strip_tags($request->input('head')),
            'slug' => strip_tags($request->input('url')),
            'description' => $request->input('body'),
            'parent_id' => $request->input('cat'),
        ]);

        $doc->save();

        flash('New category ' . $doc->name . ' created successfully')->success();

        return redirect()->route('category-index');
    }

    /**
     * Shows an edit form to edit a given category
     */
    protected function editCategory($id)
    {
        if (!$this->checkCategoryActionPermissions('edit')) {
            return redirect()->back();
        }

        $category = Category::findOrFail($id);

        return view('category.edit', compact('category'));
    }

    /**
     * Saves changes to existing category
     */
    protected function saveCategory(Request $request)
    {
        if (!$this->checkCategoryActionPermissions('save')) {
            return redirect()->back();
        }

        $id = $request->input('id');
        $parent_id = $request->input('cat');

        // make sure the supplied parent is not actually
        // also a child of this category
        if (!empty($parent_id) && $this->hasCyclicDependency($id, $parent_id)) {
            return redirect()
                ->route('category-edit', $id)
                ->withMessage('The selected parent category is also a child of this category');
        }

        $category = Category::findOrFail($id);
        $category->name = strip_tags($request->input('head'));
        $category->slug = $request->input('url');
        $category->description = $request->input('body');
        $category->parent_id = $parent_id;
        $category->save();

        flash('Category saved')->success();

        return redirect()->route('category-edit', $id);
    }

    /**
     * Shows a list of all the comments made to any
     * page in past days (default: past 90 days)
     */
    protected function comments($pastDays = 90)
    {
        $comments = Comment::with(['user', 'page:id,title'])
                    ->whereDate('comments.created_at', '>=', Carbon::today()->subDays($pastDays)->toDateString())
                    ->orderBy('page_id', 'created_at')
                    ->paginate(50);

        return view('admin.comments')->withComments($comments);
    }

    /**
     * Permanently deletes a specific comment
     */
    protected function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        flash('Comment deleted successfully')->success();

        return redirect()->route('admin-comments');
    }

    /**
     * Shows the design page under admin menu
     */
    protected function design()
    {
        return view('admin.design');
    }

    protected function showSettings()
    {
        return view('admin.settings', [
            'storage' => Configuration::getConfig('storage')
        ]);
    }

    /**
     * A private function to return only the needed data to create
     * page listing (it excludes big columns such as 'markup')
     */
    private function listPages()
    {
        return DB::table('pages')
            ->leftJoin('users', 'pages.user_id', 'users.id')
            ->leftJoin('categories', 'pages.category_id', 'categories.id')
            ->select(DB::raw('pages.id, pages.title, pages.created_at, pages.updated_at, users.name as author, case when categories.name is null then "uncategorized" else categories.name end as category'))
            ->get();
        // paginatin will be handled in frontend for smaller (less than 5000 entries) lists
                //->paginate(20);
    }

    /**
     * A handy function to get a new or existing page object
     */
    private function getPageObject($id = null)
    {
        if (empty($id)) {
            return new Page();
        } else {
            return Page::findOrFail($id);
        }
    }

    /**
     * Checks whether the user accessing the page has permission
     * to perform the intended operation, e.g., edit or delete
     */
    private function checkPageActionPermissions($action, $resource = null)
    {
        $userType = Auth::user()->type;

        // admin should be able to do anything
        if ($userType == 'Admin') {
            return true;
        }

        // editor is like admin, but does not have delete rights
        if ($userType == 'Editor' && $action != 'delete') {
            return true;
        }

        // authors are like editors, but they can only change
        // their own documents or create new documents
        if ($userType == 'Author' && in_array($action, ['edit', 'save'])) {
            // access editor or save route to create new page is fine
            if (empty($resource->id)) {
                return true;
            }

            // access editor to save own page is fine
            if (!empty($resource->id) && $resource->author->id === Auth::user()->id) {
                return true;
            }
        }

        // for everything else, deny permission
        flash('You do not have permission to ' . $action . ' this page')->warning();

        return false;
    }

    /**
     * Determines whether a specific user has permission
     * to perform the given action on categories
     */
    private function checkCategoryActionPermissions($action)
    {
        $type = Auth::user()->type;

        // admin should be able to do anything
        if ($type == 'Admin') {
            return true;
        }

        // for everything else, deny permission
        flash('You do not have permission to ' . $action . ' category')->warning();

        return false;
    }

    /**
     * Checks whether a category is being updated with a
     * parent_id equal to the id of one of its descendants
     */
    private function hasCyclicDependency($id, $parent_id)
    {
        $parent_category = Category::findOrFail($parent_id);
        $p = $parent_category->parent;
        if (empty($p)) {
            return false;
        }
        if ($p->id == $id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the cumulative count for a list of items.
     * Eac item in items must contain a 'count' property
     */
    private function getCumulativeGrowth(array $items, $cumeColumns)
    {
        $previousCount = [];
        for ($index = 0; $index < count($items); $index++) {
            foreach ($cumeColumns as $column) {
                $items[$index]->$column = $items[$index]->$column + ($previousCount[$column] ?? 0);
                $previousCount[$column] = $items[$index]->$column;
            }
        }

        return $items;
    }

    private function getDayWiseGrowth()
    {
        $sql = 'SELECT '
                    . 'base_data.year, '
                    . 'base_data.month, '
                    . 'base_data.day, '
                    . 'cast(SUM(base_data.users_joined) as unsigned) users, '
                    . 'cast(SUM(base_data.page_created) as unsigned) pages '
                . 'FROM ( '
                    . 'SELECT '
                        . 'year(created_at) year, '
                        . 'month(created_at) month, '
                        . 'day(created_at) day, '
                        . '1 users_joined, '
                        . '0 page_created '
                    . 'FROM users u '
                    . 'UNION ALL '
                    . 'SELECT '
                        . 'year(created_at) year, '
                        . 'month(created_at) month, '
                        . 'day(created_at) day, '
                        . '0 users_joined, '
                        . '1 page_created '
                    . 'FROM pages p'
                . ') base_data '
                . 'GROUP BY '
                    . 'base_data.year, '
                    . 'base_data.month, '
                    . 'base_data.day '
                . 'ORDER BY '
                    . 'base_data.year, '
                    . 'base_data.month, '
                    . 'base_data.day ';

        return DB::select($sql);
    }
}
