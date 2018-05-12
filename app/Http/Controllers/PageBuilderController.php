<?php
namespace App\Http\Controllers;


class PageBuilderController extends Controller{
    public function index() {
        return view('page-builder');
    }
}