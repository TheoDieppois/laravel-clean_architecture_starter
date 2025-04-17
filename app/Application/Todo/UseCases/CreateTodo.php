<?php
namespace App\Application\Todo\UseCases;

use App\Application\Todo\DTO\CreateTodoInput;
use App\Application\Todo\DTO\TodoOutput;
use App\Application\Todo\Mappers\TodoInputMapper;
use App\Application\Todo\Mappers\TodoOutputMapper;
use App\Domain\Todo\TodoRepository;

final class CreateTodo
{
    public function __construct(private readonly TodoRepository $repository) {}

    public function execute(CreateTodoInput $input): TodoOutput
    {
        $todo = TodoInputMapper::toEntity($input);

        $this->repository->save($todo);
        return TodoOutputMapper::toDto($todo);
    }
}
