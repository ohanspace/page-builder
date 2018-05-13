<?php 
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller {

    function __construct() {
    }

    public function getList() {
        return Page::all();
    }

    public function create(Request $request) {
        $content = $request->getContent();
        $pageData = json_decode($content);
       
        $page = new Page();
        $page->title = $pageData->title;
        $page->slug = $pageData->slug;
        $page->html = $pageData->html;
        $page->css = $pageData->css;

        if ($page->save()) {
            return $page;
        }
    }

    public function update(Request $request) {
        $content = $request->getContent();
        $pageData = json_decode($content);
        $page = Page::find($pageData->id);

        $page->title = $pageData->title;
        $page->slug = $pageData->slug;
        $page->html = $pageData->html;
        $page->css = $pageData->css;

        $page->save();
        return $page;
    }


    public function delete(Request $request) {
        $content = $request->getContent();
        $pageData = json_decode($content);
        $page = Page::find($pageData->id);
        $page->delete();
        return $page;
        //$page->delete();
    }
}