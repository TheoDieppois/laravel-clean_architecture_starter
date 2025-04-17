<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateTodoRequest;
use App\Application\Todo\DTO\CreateTodoInput;
use App\Application\Todo\UseCases\CreateTodo;
use App\Application\Todo\UseCases\ListTodos;
use App\Application\Todo\UseCases\CompleteTodo;
use App\Application\Todo\UseCases\DeleteTodo;
use App\Application\Todo\UseCases\FindTodo;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    public function __construct(
        private readonly CreateTodo $createTodo,
        private readonly ListTodos $listTodos,
        private readonly CompleteTodo $completeTodo,
        private readonly DeleteTodo $deleteTodo,
        private readonly FindTodo $findTodo,
    ) {}

    public function index(): JsonResponse
    {
        $todos = $this->listTodos->execute();

        return response()->json($todos);
    }

    public function show(string $id): JsonResponse
    {
        $todo = $this->findTodo->execute($id);

        if (!$todo) {
            return response()->json("Todo not found", 404);
        }

        return response()->json($todo);
    }

    public function store(CreateTodoRequest $request): JsonResponse
    {
        $input = new CreateTodoInput(
            title: $request->input('title'),
        );

        $todo = $this->createTodo->execute($input);

        return response()->json($todo, 201);
    }

    public function complete(string $id): JsonResponse
    {
        $this->completeTodo->execute($id);
        return response()->json(null, 204);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->deleteTodo->execute($id);
        return response()->json(null, 204);
    }
}
