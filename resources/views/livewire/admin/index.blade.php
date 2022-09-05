<div class="container mx-auto flex items-center justify-center min-h-screen">
    <div class="mockup-window border border-base-300 mt-12">
        <div class="flex justify-center px-4 py-16 border-t border-base-300 ">
            <div class="flex items-center justify-center ">
                <div class="px-8 py-6 mx-4 mt-4 text-right ">
                    <h3 class="text-2xl font-bold text-center">پست جدید !</h3>
                    <form  class="form-horizontal" wire:submit.prevent="CreateBlog" enctype="multipart/form-data" role="form">
                       
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
                                <label class="block" for="title">عنوان پست<label>
                                <input wire:model.lazy="blog.title" type="text" name="title" id="title" placeholder="عنوان پست" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                                @error('blog.title')
                                    <span class="text-xs text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label class="block" for="description">متن پست<label>
                                <textarea wire:model.lazy="blog.description" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" placeholder="متن پست"></textarea>
                                @error('blog.description')
                                    <span class="text-xs text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label for="password" class="block">عکس پست<label>
                                <input id="file" type="file" wire:model="photo">
                                @error('photo')
                                    <span class="text-xs text-red-400">{{ $message }}</span>
                                @enderror
                            </div>


                            
                            <div class="flex">
                                <button class="w-full px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">ایجاد پست</button>
                            </div>

                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="btm-nav">
        
        <button class="active" wire:click="goToNewPost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg> پست جدید
        </button>
        <button wire:click="goToAllPosts">
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
