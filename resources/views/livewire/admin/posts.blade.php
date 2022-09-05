<div class="container mx-auto flex items-center justify-center min-h-screen">
    
    <div class="overflow-x-auto w-full">
        <table class="table w-full">
          
          <thead>
            <tr>
              <th>تصویر</th>
              <th>عنوان</th>
              <th>توضیحات</th>
              <th>اقدامات</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($posts as $post)    
                <tr>
                    <th><img src="{{$post->image}}" class="w-20 h-20 rounded-lg" alt="{{$post->title}}"></th>
                    <td>{{$post->title}}</td>
                    <td>{{$post->description}}</td>
                    <td>
                        <button class="btn bg-red-500 text-white" wire:click="deleteBlog({{$post->id}})">حذف</button>
                    </td>
                </tr>
            @endforeach
           
          </tbody>
        </table>
        
      </div>

    <div class="btm-nav">
        
        <button wire:click="goToNewPost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg> پست جدید
        </button>
        <button class="active" wire:click="goToAllPosts">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg> پست ها
        </button>
        <button wire:click="goToAllComments">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
            </svg> نظر ها
        </button>
        
      </div>
</div>
