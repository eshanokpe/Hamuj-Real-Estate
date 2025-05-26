<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Post; 
use App\Models\Comment; 

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
        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'slug' => Str::slug($validated['title']),
        ];
       
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('assets/images/post'), $imageName);
        }
    
        Post::create(array_merge($data, ['image' => 'assets/images/post/'.$imageName]));
    
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
        $updateData = [
            'title' => $request->title,
            'content' => $request->content,
        ];
    
        // Update slug only if the title has changed
        if ($post->title !== $request->title) {
            $updateData['slug'] = Str::slug($request->title);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('assets/images/post'), $imageName);
            
            $post->update(['image' =>  'assets/images/post/' . $imageName]);
        }
        $post->update($updateData);
       
        return redirect()->route('admin.post.index')->with('success', 'Post Updated successfully.');
    }

    public function show($slug){
        try {
            $post = Post::with(['comments' => function ($query) {
                $query->whereNull('parent_id')->with('replies');
            }])->where('slug', $slug)->firstOrFail();
            $wordCount = str_word_count(strip_tags($post->content));
            $readingTime = ceil($wordCount / 200);

            return view('home.pages.blog.show', compact('post','readingTime'));
        } catch (\Exception $e) {
            \Log::error('Error fetching property: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An unexpected error occurred.');
        }
    }

    public function storeComment(Request $request){
        // Validate incoming request
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
    
        Comment::create($request->all());
        return response()->json(['message' => 'Comment submitted successfully']);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail(decrypt($id));
        $post->delete();
        return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully.');
    }



    

}
