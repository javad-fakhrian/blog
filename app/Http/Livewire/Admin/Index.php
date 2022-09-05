<?php

namespace App\Http\Livewire\Admin;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $photo;

    public Blog $blog;

    public function mount(){
        $this->blog = new Blog();
    }

    protected $rules = [
        'blog.title' => 'required|min:2',
        'blog.description' => 'required|min:2',
        'photo' => 'required|image'        
        
    ];

    public function updated($name)
    {
        $this->validateOnly($name);
    }

    public function CreateBlog()
    {
        $this->validate();
        $img = $this->photo->store('images', 'blog');
        $this->blog['image'] = '/blog/'.$img;
        $this->blog['user_id'] = auth()->user()->id;
        $this->blog->save();

        return redirect(route('admin.index'))->with('success','پست با موفقیت منتشر شد !');
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
        return view('livewire.admin.index');
    }
}
