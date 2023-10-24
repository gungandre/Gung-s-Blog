@extends('dashboard.layouts.main')


@section('container')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="row  my-3">
            <div class="col-lg-8">
                <h2 class="mb-5">{{ $post->title }}</h2>
                <a href="/dashboard/posts" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg> Back to my posts</a>
                <a href="" class="btn btn-warning"> Edit</a>
                <form action="/dashboard/posts/{{ $post->slug }}/edit" class="d-inline" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger border-0" onclick="return confirm('Are you sure?')">
                        Delete</button>

                </form>

                {{-- ! tanda {!!} digunakan agar format html yang ada di database bisa di eksekusi karna {{}} untuk mmelindungi agar tidak bisa dilakukan sql injection --}}

                @if ($post->image)
                    {{-- method asset sudah langsung mengarah ke folder public --}}
                    <div style="max-height: 350px; overflow: hidden;">
                        <img class="img-fluid mt-3" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->image }}">
                    </div>
                @else
                    <img class="img-fluid mt-3" src="https://source.unsplash.com/1200x400/?{{ $post->category->nama }}"
                        alt="">
                @endif


                <article class="my-3">
                    {!! $post->body !!}
                </article>


            </div>
        </div>
    </main>
@endsection
