@extends('layouts.app')

@section('content')

@if(session()->has('message'))
    <div class="mx-auto w-4/5 pb-10">
        <div class="bg-yellow-500 text-white font-bold-rounded-t px-4 py-2">
            Warning
        </div>
        <div class="border border-t-1 border-red-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
            {{ session()->get('message') }}
        </div>
    </div>
@endif

@foreach($posts as $post)
<div class="w-4/5 mx-auto pb-10">
    <div class="bg-white pt-10 rounded-lg drop-shadow-2xl sm:basis-3/4 basis-full sm:mr-8 pb-10 sm:pb-0">
        <div class="w-11/12 mx-auto pb-10">
            <h2 class="text-gray-900 text-2xl font-bold pt-6 pb-0 sm:pt-0 hover:text-gray-700 transition-all">
                <a href="{{ route('blog.show', $post->id) }}">
                    {{ $post->title }}
                </a>
            </h2>

            <p class="text-gray-900 text-lg py-8 w-full break-words">
                {{ $post->excerpt }}
            </p>

            <p class="text-base text-black pt-10">
                {{ $post->body }}
            </p>

            <span class="text-gray-500 text-sm sm:text-base">
                Made by:
                    <a href=""
                    class="text-green-500 italic hover:text-green-400 hover:border-b-2 border-green-400 pb-3 transition-all">
                        Dary
                    </a>
                op 13-07-2022
            </span>

            <a href="{{ route('blog.edit', $post->id) }}" class="block italic text-green-500 border-b-1 border-green-400">
                Edit
            </a>
            
            <form action="{{ route('blog.destroy', $post->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="pt-3 text-red-500 pr-3">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="mx-auto pb-10 w-4/5">
    {{ $posts->links('vendor.pagination.tailwind') }}
</div>

@stop