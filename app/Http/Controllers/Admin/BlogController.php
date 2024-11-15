<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Post; 

class BlogController extends Controller
{
    public function index(){
        return view('admin.home.blog.index');
    }

    public function create(){
        return view('admin.home.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

       
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('assets/images/post'), $imageName);
        }
    
        Post::create(array_merge($validated, ['image' => 'assets/images/post/'.$imageName]));
    
        return redirect()->route('admin.post.create')->with('success', 'Post created successfully.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail(decrypt($id));
        return view('admin.home.blog.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:5048', 
        ]);
        $post = Post::findOrFail($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('assets/images/post'), $imageName);
            
            $post->update(['image' =>  'assets/images/post/' . $imageName]);
        }
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return redirect()->route('admin.post.index')->with('success', 'Post Updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail(decrypt($id));
        $post->delete();
        return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully.');
    }

    

}
