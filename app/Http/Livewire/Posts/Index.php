<?php

namespace App\Http\Livewire\Posts;

use App\Models\Blog;
use App\Models\Comment;
use Livewire\Component;

class Index extends Component
{
    public Blog $blog;

    public Comment $comment;

    public function mount(){
        $this->comment = new Comment();
    }

    protected $rules = [
        'comment.comment' => 'required|min:2'
    ];

    public function updated($name)
    {
        $this->validateOnly($name);
    }

    public function CreateComment()
    {
        $this->validate();
        $this->comment['blog_id'] = $this->blog->id;
        $this->comment['user_id'] = auth()->user()->id;
        $this->comment->save();

        return redirect(route('post.index',['blog'=>$this->blog->id]))->with('success','نظر شما ثبت شد');
    }

    public function render()
    {
        return view('livewire.posts.index');
    }
}
