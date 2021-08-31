<?php

namespace App\Http\Controllers\Api;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
class CategoryController extends Controller
{
    public function index()
    {
        return new CategoryResource(Category::all());
    }
    public function getwithid($id){
        $cat=Category::findOrFail($id);
        return new CategoryResource($cat);
    }

    public function store(Request $request)
    {
       $data = $request->all();
       if($request->hasFile('photo')){
           $file = $request->file('photo');
           $name= 'public/storage/category/'  . $request['name'] . '.'. $file->extension();
           $file->storePubliclyAs('public',$name);
           $data['photo'] = $name;
       }
       $cat = Category::create($data);
       return new CategoryResource($cat);
    }
}
