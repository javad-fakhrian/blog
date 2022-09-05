<?php

namespace App\Http\Livewire\Main;

use App\Models\Blog;
use Livewire\Component;

class Posts extends Component
{
    public function render()
    {
        $posts = Blog::all();
        return view('livewire.main.posts' , compact('posts'));
    }
}
