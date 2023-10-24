@extends('layouts.main')


@section('container')
    <div class="container">

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <h2 class="mb-5">{{ $post->title }}</h2>
                <p>By. <a href="/authors/{{ $post->author->username }}" class="text-decoration-none">
                        {{ $post->author->name }} </a>
                    in <a class="text-decoration-none"
                        href="/blog?category={{ $post->category->slug }}">{{ $post->category->nama }}</a>
                </p>

                {{-- ! tanda {!!} digunakan agar format html yang ada di database bisa di eksekusi karna {{}} untuk mmelindungi agar tidak bisa dilakukan sql injection --}}


                @if ($post->image)
                    {{-- method asset sudah langsung mengarah ke folder public --}}
                    <div style="max-height: 450px; overflow: hidden;">
                        <img class="img-fluid mt-3" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->image }}">
                    </div>
                @else
                    <img class="img-fluid mt-3" src="https://source.unsplash.com/1200x400/?{{ $post->category->nama }}"
                        alt="">
                @endif


                <article class="my-3">
                    {!! $post->body !!}
                </article>

                <a href="/blog">Back to Blog</a>
            </div>
        </div>

    </div>

    {{-- <article>

    </article> --}}
@endsection
