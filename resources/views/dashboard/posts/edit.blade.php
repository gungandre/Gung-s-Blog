@extends('dashboard.layouts.main')

@section('container')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit New Post</h1>
        </div>
        <div class="col-lg-8">
            <form method="POST" action="/dashboard/posts/{{ $post->slug }}" class="mb-5" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $post->title) }}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                        name="slug" value="{{ old('slug', $post->slug) }}">
                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Category</label>
                    <select type="text" class="form-select" id="category_id" name="category_id">
                        @foreach ($categories as $category)
                            @if (old('category_id', $post->category_id) == $category->id)
                                <option value="{{ $category->id }}" selected>{{ $category->nama }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->nama }}</option>
                            @endif
                        @endforeach

                    </select>

                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label  @error('image') is-invalid @enderror">Post Image</label>
                    <input type="hidden" name="oldImage" value="{{ $post->image }}">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt=""
                            class="img-preview img-fluid mb-3 col-sm-5 d-block" id="imgprev">
                    @else
                        <img src="" alt="" class="img-preview img-fluid mb-3 col-sm-5 d-block"
                            id="imgprev">
                    @endif
                    <input class="form-control" type="file" name="image" id="image" onchange="previewImage()">

                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>
                    @error('body')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
                    <trix-editor input="body"></trix-editor>
                </div>


                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </div>



    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title');
            const slug = document.getElementById('slug');



            // ! mengirimkan data slug ke dalam controller lalu  di olah menggunakan library sluggable php
            title.addEventListener('change', function(e) {
                console.log(title.value)
                fetch(`/dashboard/posts/cekSlug?title=${title.value}`)
                    .then(response => response.json())
                    .then(data => slug.value = data.slug).catch((err) => console.log(err));
            });

            document.addEventListener('trix-file-accept', function(e) {
                e.preventDefault()
            })
        });


        function previewImage() {
            const image = document.getElementById('image')
            const imgPreview = document.getElementById('imgprev')

            imgPreview.style.display = 'block'

            // oFReader adalah method bawaan dari javascript

            const oFReader = new FileReader()
            oFReader.readAsDataURL(image.files[0])

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }

        }
    </script>
@endsection
