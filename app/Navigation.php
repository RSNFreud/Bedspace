<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $table = 'navigationmenu';
    public $timestamps = false;

    static public function addPage($pageData)
    {
        $url = strtolower($pageData->pageTitle);
        $url = str_replace(" ", "-", $url);
        $page = new self;
        $page->navName = $pageData->pageTitle;
        $page->navContent = $pageData->pageContent;
        $page->navURL = $url;
        $page->save();
    }
    static public function editPage($pageData, $id)
    {
        $url = strtolower($pageData->pageTitle);
        $url = str_replace(" ", "-", $url);
        $page = self::where("navURL", $id)->first();
        $page->navName = $pageData->pageTitle;
        $page->navContent = $pageData->pageContent;
        $page->navURL = $url;
        $page->save();
    }
}
