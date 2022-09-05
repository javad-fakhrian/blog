<div>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content flex-col lg:flex-row">
          <img src="{{$blog->image}}" alt="{{$blog->title}}" class="max-w-sm rounded-lg shadow-2xl" />
          <div>
            <h1 class="text-5xl font-bold">{{$blog->title}}</h1>
            <p class="py-6">{{$blog->description}}</p>
          </div>
        </div>
    </div>

    <div class="flex items-center justify-center ">
        <div class="px-8 py-6 mx-4 mt-4 text-right ">
            <h3 class="text-2xl font-bold text-center">ثبت نظر !</h3>
            <form  class="form-horizontal" wire:submit.prevent="CreateComment" enctype="multipart/form-data" role="form">
               
                <div class="mt-4">
                    @if ($message = Session::get('success'))
                        <div class="mt-14 mb-14">
                            <div class="alert alert-success shadow-lg">
                                <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>{{ $message }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <textarea wire:model.lazy="comment.comment" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" placeholder="متن نظر"></textarea>
                        @error('comment.comment')
                            <span class="text-xs text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                 
                    <div class="flex">
                        <button class="w-full px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">ثبت</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

    <div class="container flex items-center justify-center flex-col">
        @foreach (\App\Models\Comment::where('blog_id',$blog->id)->where('approved',1)->get() as $comment)
            <div class="mockup-code mt-4 mb-8">
                <pre><code>{{\App\Models\User::find($comment->user_id)->name}} <br> <div class="mr-12">{{$comment->comment}}</div></code></pre>
            </div>
        @endforeach
    </div>
</div>
