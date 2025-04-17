<?php
namespace App\Application\Todo\UseCases;

use App\Domain\Todo\TodoRepository;
use App\Domain\Todo\Entity\Todo;
use App\Application\Todo\Mappers\TodoOutputMapper;
use App\Application\Todo\DTO\TodoOutput;

final class FindTodo
{
    public function __construct(private readonly TodoRepository $repository) {}

    public function execute(string $id): TodoOutput | null
    {
        $todo = $this->repository->findById($id);

        if (!$todo) return null;

        return TodoOutputMapper::toDto($todo);
    }
}
