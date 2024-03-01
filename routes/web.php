<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Task;
use App\Http\Requests\TaskRequest;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* class Task
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public ?string $long_description,
        public bool $completed,
        public string $created_at,
        public string $updated_at
    ) {
    }
}

$tasks = [
    new Task(
        1,
        'Buy groceries',
        'To be done on Sunday',
        'Make sure to buy milk and other stuff for the fridge and pantry',
        false,
        '2023-03-01 12:00:00',
        '2023-03-01 12:00:00'
    ),
    new Task(
        2,
        'Sell old stuff',
        'Need to declutter the house',
        null,
        false,
        '2023-03-02 12:00:00',
        '2023-03-02 12:00:00'
    ),
    new Task(
        3,
        'Learn programming',
        'For starting freelance work',
        'Got to make the big bucks',
        true,
        '2023-03-03 12:00:00',
        '2023-03-03 12:00:00'
    ),
    new Task(
        4,
        'Take dogs for a walk',
        'What dogs, there are no dogs',
        null,
        false,
        '2023-03-04 12:00:00',
        '2023-03-04 12:00:00'
    ),
]; */

//Home Page
Route:: get ('/', function(){
    return redirect()-> route('tasks.index');
});

//Home Page
Route::get('/tasks', function () {    
    return view('index',[
       // 'tasks'=>\App\Models\Task::latest()->get()
        //'tasks'=>Task::latest()->get()
        'tasks'=>Task::latest()->paginate()

    ]);    
})-> name('tasks.index');

//Create New Task
Route::view ('/tasks/create', 'create') 
    -> name('tasks.create');

//Edit existing task
Route::get('/tasks/{task}/edit', function(Task $task){
    return view('edit',['task'=>$task]);
    //return view('edit',['task'=>Task::findOrFail($id)]);
}) ->name('tasks.edit');;

//Display individual task
Route::get('/tasks/{task}', function(Task $task){    
    return view('show',['task'=>$task]);
    
    
    /*return 'one single task'.$id;
    return view('show',['task'=>\App\Models\Task::findOrFail($id)]);
    $task = collect($tasks)-> firstwhere('id', $id); //Make note    
     if(!$task){
        abort(Response::HTTP_NOT_FOUND);
    }
    return view('show', ['task'=> $task]); */

}) -> name('tasks.show');

//Save New task to DB
Route::post('/tasks', function(TaskRequest $request){
  /*   $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'long_description' => 'required'
    ]); 
    */
/* 
    $data = $request->validated();
    $task = new Task;
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->completed = '0';
    $task->save(); 
*/
    $task = Task::create($request->validated());
    //take care of fillable properties

    return redirect()-> route('tasks.show',['task'=> $task])
        ->with('success','Task created successfully');
}) -> name('tasks.store');

//Update existing task in DB
Route::put('/tasks/{task}', function(TaskRequest $request,Task $task){
    /*   $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'long_description' => 'required'
        ]);          
        $task = Task::findOrFail($id);
        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->long_description = $data['long_description'];
        $task->save();
    */

    $task->update($request->validated());

    return redirect()-> route('tasks.show',['task'=> $task])
        ->with('success','Task udated successfully');
}) -> name('tasks.update');

//Delete task
Route::delete('/tasks/{task}', function(Task $task){
    $task->delete();
    return redirect()->route('tasks.index')
        ->with('success','Task deleted successfully');
})->name('tasks.destroy');

//404 Page not found
Route::fallback(function(){
    return "OOpsie";
});

//to toggle complete
Route::put('tasks/{task}/toggle-complete', function(Task $task){
    $task->toggleComplete();
    return redirect()->back()->with('success','Task updated successfully');
})->name('tasks.toggle-complete');

/*Route::get('/wAlla', function(){
    return redirect()-> route('main');
})-> name("hello");

Route::get('/greet/{name}', function($name){
    return "Hello ".$name;
});*/

