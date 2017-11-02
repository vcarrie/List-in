<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagsController extends Controller
{
    public function getTags(){
        $tags = Tag::all()->toJson();
        return $tags;
    }
}
