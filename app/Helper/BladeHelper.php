<?php
use Symfony\Component\Debug\Exception\FatalThrowableError;

class BladeHelper
{

    // public static function render($__php, $__data = array())
    // {
    // 	$__data['__env'] = app(\Illuminate\View\Factory::class);
    // 	$obLevel = ob_get_level();
    // 	ob_start();
    // 	extract($__data, EXTR_SKIP);
    // 	try {
    // 		eval('?' . '>' . $__php);
    //  }
    // 	catch (Exception $e) {
    //      while (ob_get_level() > $obLevel)
    // 			ob_end_clean();
    // 		throw $e;
    //  }
    // 	catch (Throwable $e) {
    //      while (ob_get_level() > $obLevel)
    // 			ob_end_clean();
    // 		throw new FatalThrowableError($e);
    // 	}
    // 	return ob_get_clean();
    // }

    // public static function siteMember ()
    // {
    //  return
    // 	in_array(Auth::user()->type, ['Registered', 'Admin', 'Editor', 'Author']);
    // }

    

    public static function loadModule($name)
    {
        $r = DB::table('modules')->where('name', $name)->get();
        return $r[0]->html ?? null;
    }

    // This function take objects with form {id: "", parent_id: ""} and
    // creates a tree structure using recursion.
    public static function buildTree(array $elements, $parentId = null)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] === $parentId) {
                $children = BladeHelper::buildTree($elements, $element['id']);
                if ($children) {
                            $element['children'] = $children;
                }
                        $branch[$element['id']] = $element;
                        unset($element);
            } // if
        } // foreach
        return $branch;
    }// function


    // This function builds a HTML list (e.g. by using <ul> and <li>)
    // from a tree structure. The function is very flexible and
    // most of the input parameters are defined below.
    public static function buildHTMLListfromTree(
        array $tree,
        // a tree structure such as returned by buildTree()
        $level = 0,
        // a value indicating the first level of the tree, usually 0
        $linkParent = true,
        // whether to use HTML anchor tag with parent elements containing sublist
        $maxLevel = -1,
        // max-level till which recursion needs to run
        $treeTag = 'ul',
        // HTML tag to be used for denoting List
        $nodeTag = 'li'       // HTML tag to be used for denoting each item inside the List
    ) {
        $value = '<' . $treeTag . ' class="level-'.$level . '">';
        foreach ($tree as $item) {
            if ($maxLevel > 0 && $level > $maxLevel) {
                return '';
            }
            if (array_key_exists('children', $item)) {
                $value .= '<' . $nodeTag .  ' class="has-children">'
                    . (($linkParent || $level == $maxLevel)?('<a href="' . $item['url'] . '">'):'')
                    . $item['name']
                    . (($linkParent || $level == $maxLevel)?'</a>':'')
                    . BladeHelper::buildHTMLListfromTree($item['children'], $level + 1, $linkParent, $maxLevel, $treeTag, $nodeTag)
                    . '</' .  $nodeTag . '>';
            } else {
                $value .= '<' . $nodeTag . '>'
                    . '<a href="' . $item['url'] . '">'
                    . $item['name']
                    . '</a>'
                    . '</' .  $nodeTag . '>';
            }
        }
        return $value . '</' . $treeTag . '>';
    }

    // ATTENTION : This only applies to Bootstrap version 3 or less
    // This function works like buildHTMLListfromTree() but it adds the required Bootstrap
    // classes to generate bootstrap style on-click 2-level drop dropdown menu.
    public static function buildBootStrap3MenufromTree(array $items, $level = 0, $class = 'nav navbar-nav')
    {
        $value = '<ul class="' . $class . '">';
        foreach ($items as $item) {
            if ($level > 1) {
                return '';
            }
            if (array_key_exists('children', $item) && $level < 1) {
                $value .= '<li class="dropdown">'
                    . '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'
                    . $item['name']
                    . ' <span class="caret"></span></a>'
                    . BladeHelper::buildBootStrapMenufromTree($item['children'], $level + 1, 'dropdown-menu')
                    . '</li>';
            } else {
                $value .= '<li>'
                    . '<a href="' . $item['url'] . '">'
                    . $item['name']
                    . '</a>'
                    . '</li>';
            }
        }
        return $value . '</ul>';
    }

        
    // ATTENTION : This only applies to Bootstrap version 4
    // This function does not support bootstrap nested submenu dropdown
    public static function buildBootStrap4MenufromTree(array $items, $level = 0, $class = 'nav d-flex justify-content-between')
    {
        $value = '<nav class="' . $class . '">';
        foreach ($items as $item) {
            $value .= '<a class="p-2 text-muted" href="' . $item['url'] . '">' . $item['name'] . '</a>';
        }
        return $value . '</nav>';
    }

    // A helper class to generate menu
    public static function buildSiteMenu(array $items)
    {
        //TODO change the function based on bootstrap version in use
        return BladeHelper::buildBootStrap4MenufromTree(BladeHelper::buildTree($items));
    }
}
