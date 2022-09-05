<?php

namespace App\Http\Livewire\Admin;

use App\Models\Blog;
use Livewire\Component;

class Posts extends Component
{
    
    public function deleteBlog($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
    }

    public function goToNewPost()
    {
        return redirect()->route('admin.index');
    }

    public function goToAllPosts()
    {
        return redirect()->route('admin.posts');
    }

    public function goToAllComments()
    {
        return redirect()->route('admin.comments');
    }

    public function render()
    {
        $posts = Blog::all();
        return view('livewire.admin.posts',compact('posts'));
    }
}
