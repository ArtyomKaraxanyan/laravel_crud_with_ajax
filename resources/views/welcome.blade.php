@extends('layouts.app')

@section('content')

    <section class="blog_grid_area">
        <div class="container">
            <main>
                <a href="{{asset(url('/create'))}}" > Create post</a>
                    @foreach($posts as $post)
                        <div class="singleBlog">
                            <img src="{{asset("images/".$post->image)}}" alt="">
                            <div class="blogContent">
                                <h3 id="name" >{{$post->name}}</h3>
                                <button class="btn" id="learn" name="leranmore" >Learn more</button>
                                <a href="{{asset(url("/edit/$post->id"))}}" class="btn">Edit this post</a>
                            </div>
                        </div>
                    @endforeach



            </main>
        </div>
    </section>

@endsection



