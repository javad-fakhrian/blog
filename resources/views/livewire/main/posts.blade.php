<div>
    <div class="container flex items-center justify-center mx-auto pt-5 pb-5  space-x-10">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

          {{-- <div class="card w-96 glass m-2 animate-pulse">
            <a href="#">
              <figure><img class="h-48 w-full rounded bg-primary" ></figure>
              <div class="card-body">
                <h2 class="card-title"><span class="h-3 w-20 rounded bg-primary mb-2"></span></h2>
                <p class="h-3 w-32 rounded bg-primary mb-8"></p>
                <div class="card-actions justify-end">
                  <button class="btn btn-primary">ادامه </button>
                </div>
              </div>
            </a>
          </div> --}}
          
          @foreach ($posts as $post)    
            <div class="card w-96 glass m-2">
                <a href="{{route('post.index',['blog'=>$post->id])}}">
                <figure><img src="{{$post->image}}" alt="{{$post->title}}"></figure>
                <div class="card-body">
                    <h2 class="card-title">{{$post->title}}</h2>
                    <p>{{$post->description}}</p>
                    <div class="card-actions justify-end">
                    <button class="btn btn-primary">ادامه </button>
                    </div>
                </div>
                </a>
            </div>
          @endforeach
          
        </div>
    </div>
</div>
