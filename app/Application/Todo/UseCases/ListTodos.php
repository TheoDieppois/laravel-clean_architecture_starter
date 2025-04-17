<?php
namespace App\Application\Todo\UseCases;

use App\Application\Todo\DTO\TodoOutput;
use App\Application\Todo\Mappers\TodoOutputMapper;
use App\Domain\Todo\TodoRepository;

final class ListTodos
{
    public function __construct(private readonly TodoRepository $repository) {}

    /** @return TodoOutput[] */
    public function execute(): array
    {
        $todos = $this->repository->findAll();
        return array_map(fn($t) => TodoOutputMapper::toDto($t), $todos);
    }
}
