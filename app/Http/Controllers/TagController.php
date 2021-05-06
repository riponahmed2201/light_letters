<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function addTag(Request $request){

        $multi_tag = explode(',',$request->tag_name);
        if($multi_tag){
            foreach ($multi_tag as $key => $value) {
                    $tag = new Tag;
                    $tag->tag_name = $value;
                    $tag->save();
            }
        }
        return response()->json(['tag_name'=>$tag->tag_name],201);
    }
    public function tagList(){
        $tag = Tag::all();
        return response()->json($tag,200);
    }
    public function tagEdit($tagname){
        $tag = Tag::where('tag_name',$tagname)->first();
        return response()->json($tag,200);
    }
    public function tagUpdate(Request $request,$tagname){
        $tag = Tag::where('tag_name',$tagname)->first();
        $tag->tag_name = $request->tag_name;
        $tag->save();
        return response()->json($tag,201);
    }
    public function tagDelete($tagname){
        $tag = Tag::where('tag_name',$tagname)->first();
        $tag->delete();
        return response()->json($tag,200);
    }
}
