<?php
namespace App\Application\Todo\UseCases;

use App\Domain\Todo\TodoRepository;

final class CompleteTodo
{
    public function __construct(private readonly TodoRepository $repository) {}

    public function execute(string $id): void
    {
        $todo = $this->repository->findById($id);
        if (!$todo) {
            throw new \DomainException("Todo with id $id not found");
        }
        $todo->markAsCompleted();

        $this->repository->update($todo);
    }
}
