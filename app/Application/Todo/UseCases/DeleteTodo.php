<?php
namespace App\Application\Todo\UseCases;

use App\Domain\Todo\TodoRepository;

final class DeleteTodo
{
    public function __construct(private readonly TodoRepository $repository) {}

    public function execute(string $id): void
    {
        $this->repository->delete($id);
    }
}
