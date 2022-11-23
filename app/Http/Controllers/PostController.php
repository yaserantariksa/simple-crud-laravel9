<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index(){
        $posts = Post::latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * create
     * 
     * @return void
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * store
     * 
     * @return void
     */
    public function store(Request $request){
        // validate input data
        $this->validate($request, [
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with(['success'=>'Data Berhasil Disimpan']);
    }

    /**
     * show
     * 
     * @return void
     */
    public function show($id){
        $post = Post::find($id);

        return view('posts.show', compact('post'));
    }

    /**
     * edit
     * 
     * @return void
     */
    public function edit(Post $post){
        return view('posts.edit', compact('post'));
    }

    /**
     * update
     * 
     * @param mixed $request
     * @param mixed $post
     * @return void
     */
    public function update(Request $request, Post $post){
        // validate form
        $this->validate($request, [
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        // check if image is uploaded
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/posts',$image->hashName());  
            
            // delete old image
            Storage::delete(['public/posts/'.$post->image]);

            // update post with new image
            $post->update([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content,
            ]);
        } else {
            // update post without image
            $post->update([
                'title'=> $request->title,
                'content' => $request->content,
            ]);
        }        
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     * 
     * @param mix $post
     * @return void
     */
    public function destroy(Post $post){
        Storage::delete('public/posts/'.$post->image);

        $post->delete();

        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
