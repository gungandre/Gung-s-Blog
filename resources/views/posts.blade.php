{{-- @dd sama seperti var_dump untuk melakukan debug --}}
{{-- @dd($post) --}}

@extends('layouts.main')


@section('container')
    <h1 class="mt-3 mb-3 text-center">{{ $title }}</h1>

    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <form action="/blog" method="GET">
                <div class="input-group mb-3">
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if (request('authors'))
                        <input type="hidden" name="authors" value="{{ request('authors') }}">
                    @endif
                    <input type="text" class="form-control" placeholder="Search" name="search"
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit" id="">Search</button>
                </div>
            </form>
        </div>
    </div>




    @if ($posts->count() > 0)
        <div class="card mb-3">

            @if ($posts[0]->image)
                {{-- method asset sudah langsung mengarah ke folder public --}}
                <div style="max-height: 350px; overflow: hidden;">
                    <img class="img-fluid mt-3" src="{{ asset('storage/' . $posts[0]->image) }}"
                        alt="{{ $posts[0]->image }}">
                </div>
            @else
                <img class="img-fluid mt-3" src="https://source.unsplash.com/1200x400/?{{ $posts[0]->category->nama }}"
                    alt="">
            @endif
            <div class="card-body text-center">
                <a href="blog/{{ $posts[0]->slug }}" class="text-decoration-none text-dark">
                    <h3 class="card-title">{{ $posts[0]->title }}</h3>
                </a>

                <p><small class="text-muted">By. <a href="/blog?authors={{ $posts[0]->author->username }}"
                            class="text-decoration-none">{{ $posts[0]->author->name }}</a>
                        in <a href="/blog?category={{ $posts[0]->category->slug }}"
                            class="text-decoration-none">{{ $posts[0]->category->nama }}</a>
                        {{ $posts[0]->created_at->diffForHumans() }}
                    </small></p>


                <p class="card-text">{{ $posts[0]->excerpt }}</p>

                <a href="blog/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Read More..</a>

            </div>
        </div>


        <div class="container">

            <div class="row">
                @foreach ($posts->skip(1) as $data)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="position-absolute px-3 py-2 text-white" style="background-color: rgba(0,0,0,0.7)">
                                <a href="/categories/{{ $data->category->slug }}"
                                    class="text-white text-decoration-none">{{ $data->category->nama }}</a>
                            </div>
                            <img src="https://source.unsplash.com/500x400/?{{ $data->category->nama }}"
                                class="card-img-top" alt="{{ $data->category->nama }}">

                            @if ($data->image)
                                {{-- method asset sudah langsung mengarah ke folder public --}}
                                <div style="max-height: 350px; overflow: hidden;">
                                    <img class="img-fluid mt-3" src="{{ asset('storage/' . $data->image) }}"
                                        alt="{{ $data->image }}">
                                </div>
                            @else
                                <img class="img-fluid mt-3"
                                    src="https://source.unsplash.com/1200x400/?{{ $data->category->nama }}" alt="">
                            @endif

                            <div class="card-body">
                                <h5><a href="/blog/{{ $data->slug }}"
                                        class="text-decoration-none">{{ $data->title }}</a>
                                </h5>
                                <p><small>Created at {{ $data->created_at->diffForHumans() }}</small></p>
                                <p>By. <a href="/blog?authors={{ $data->author->username }}"
                                        class="text-decoration-none">{{ $data->author->name }}</a>
                                    in <a href="/blog?category={{ $data->category->slug }}"
                                        class="text-decoration-none">{{ $data->category->nama }}</a></p>
                                <p>{{ $data->excerpt }}</p>
                                <a href="/blog/{{ $data->slug }}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No Post Found! </p>
    @endif


    {{-- ! untuk menggunakan fitur next prev pagination kita hanya menggunakan method links() saja maka elemen nya akan dibuat oleh laravel, tetapi secara default css menggunakan tailwind. untuk menggantinya menggunakan bootstrap kita bisa pergi ke app/provider/appserviceprovider lalu di method root ubah menjadi useBootstrap --}}

    <div class="d-flex justify-content-end">
        {{ $posts->links() }}
    </div>


    {{-- method skip digunakan untuk perulangan yang di lewati index 0 nya karena index 0 sudah ada di gambar --}}

    {{-- <article class="mb-3 border-bottom">
        <h2><a href="/blog/{{ $data->slug }}" class="text-decoration-none">{{ $data->title }}</a> </h2>
        <p>By. <a href="/authors/{{ $data->author->username }}" class="text-decoration-none">{{ $data->author->name }}</a>
            in <a href="/categories/{{ $data->category->slug }}"
                class="text-decoration-none">{{ $data->category->nama }}</a></p>

        <p>{{ $data->excerpt }}</p>

        <a href="blog/{{ $data->slug }}" class="text-decoration-none">Read More..</a>
    </article> --}}
@endsection
