@extends('layouts.app')

@section('content')
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
        </div>
    </div>
</div>
@endforeach

@stop