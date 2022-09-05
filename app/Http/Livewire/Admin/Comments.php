<?php

namespace App\Http\Livewire\Admin;

use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{

    public function ActiveComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment['approved'] = 1 ;
        $comment->update();
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
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
        $comments = Comment::all();
        return view('livewire.admin.comments',compact('comments'));
    }
}
