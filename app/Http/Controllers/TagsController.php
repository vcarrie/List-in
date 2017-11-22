<?php

namespace App\Http\Controllers;

use App\Categorize;
use Illuminate\Http\Request;
use App\Tag;

class TagsController extends Controller
{
    public function getTags(){
        $tags = Tag::all();
        return $tags;
    }

    public function manageTags(){
        $tags = $this->getTags();
        return view('manageTags', compact('tags'));
    }

    public function deleteTags(Request $request){
        $tags = $request->tags;

        foreach ($tags as $tag){
            Categorize::deleteCategorizeByIdTag($tag);
            Tag::find($tag)->delete();
        }

        return redirect()->action('TagsController@manageTags');
    }

    public function createTags(Request $request){
        Tag::insert(array('tagName' => $request->newTag));

        return redirect()->action('TagsController@manageTags');
    }
}
