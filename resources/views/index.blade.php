
@extends('layouts.app')

@section ('title')
list of tasks
@endsection

@section ('content')
    {{--@if(count($tasks))--}}
    @forelse($tasks as $task)
        <div> 
            <li>
                <a href="{{route('tasks.show', ['task'=> $task])}}"
                    @class(['line-through'=>$task->completed])>{{$task -> title}} </a>
            </li>
            
        </div>
    @empty 
        <div> there are no tasks !
        </div>
    @endforelse
    <nav class="mb-4 mt-4">
        <form action="{{route('tasks.create')}}" method="get">
            @csrf
            <button class="font-medium text-gray-700 underline decoration-pink-500" type="submit">
                Add a new task
            </button>
        </form>
    </nav >
    @if($tasks->count())
        <nav classs="mt-4">
        {{$tasks->links()}}
        </nav>
    @endif
@endsection    
