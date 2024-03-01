
@extends('layouts.app')

@section ('title', $task -> title)

@section('content')
    

    <p class="mb-4 text-slate-700">Task description: {{ $task -> description }} </p>

    @if($task-> long_description)
    <p class="mb-4 text-slate-700">Task long description: {{ $task -> long_description }} </p>

    @endif
    <p>Task Status:
        <span class="mb-4 text-sm {{$task ->completed? 'text-green-500': 'text-orange-500'}}">
            {{ $task -> completed? "Completed" : "Open Task" }}
        </span>
    </p>    
    <p class="mb-4 text-sm text-slate-500">
        Task created: {{ $task -> created_at->diffForHumans() }}
        - Task Updated: {{ $task -> updated_at->diffForHumans() }} 
    </p>
    <span class="btn">
        <a href={{route('tasks.edit',['task'=> $task])}} >
            Edit
        </a>
    </span>
    <div>
        <form action={{route('tasks.toggle-complete',['task'=> $task])}} method="POST">
            @method('PUT')
            @csrf
            <button class="btn" TYPE='submit'>{{$task->completed?"Mark as Open" : "Mark as Complete"}}</button>
        </form>
    </div>
    <div>
        <form action={{route('tasks.destroy',['task'=> $task])}} method="POST">
            @method('DELETE')
            @csrf
            <button class="btn" TYPE='submit'>Delete Task</button>
        </form>
    </div>
    <nav>
        <a class="font-medium text-gray-700 underline decoration-pink-500" type="submit" href="{{route('tasks.index')}}">
           <- Go to Home Page
        </a>
    </nav>
@endsection