<?php

namespace Tests\Unit\UseCases;

use PHPUnit\Framework\TestCase;
use App\Application\Todo\UseCases\DeleteTodo;
use App\Domain\Todo\TodoRepository;

class DeleteTodoTest extends TestCase
{
    public function testShouldDeleteTodo()
    {
        $id   = '123e4567-e89b-12d3-a456-426614174000';

        $repo = $this->createMock(TodoRepository::class);
        $repo->expects($this->once())
             ->method('delete')
             ->with($id);

        $useCase = new DeleteTodo($repo);
        $useCase->execute($id);
    }
}
