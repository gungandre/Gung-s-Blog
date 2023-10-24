{{-- @dd sama seperti var_dump untuk melakukan debug --}}
{{-- @dd($post) --}}

@extends('layouts.main')



@section('container')
    <div class="container">
        <h1 class="mt-3">Post Categories</h1>
        <div class="row mt-5">
            @foreach ($categories as $category)
                <div class="col-md-4">
                    <a href="/categories/{{ $category->slug }}">
                        <div class="card bg-dark text-white">
                            <img src="https://source.unsplash.com/500x500/?{{ $category->nama }}" class="card-img"
                                alt="{{ $category->nama }}">
                            <div class="card-img-overlay d-flex align-items-center p-0">
                                <h5 class="card-title text-center flex-fill fs-3 p-3"
                                    style="background-color: rgba(0, 0, 0, 0.7)">
                                    {{ $category->nama }}</h5>

                            </div>
                        </div>
                    </a>


                </div>
            @endforeach
        </div>
    </div>
@endsection
