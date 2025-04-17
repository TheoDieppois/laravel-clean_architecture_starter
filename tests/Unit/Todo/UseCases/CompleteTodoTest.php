<?php

namespace Tests\Unit\UseCases;

use PHPUnit\Framework\TestCase;
use App\Application\Todo\UseCases\CompleteTodo;
use App\Domain\Todo\TodoRepository;
use App\Domain\Todo\Entity\Todo;

class CompleteTodoTest extends TestCase
{
    public function testShouldMarkTodoAsCompleted()
    {
        $id   = '123e4567-e89b-12d3-a456-426614174000';
        $todo = Todo::reconstruct(
            id:        $id,
            title:     'à compléter',
            completed: false,
            createdAt: new \DateTimeImmutable()
        );

        $repo = $this->createMock(TodoRepository::class);
        $repo->expects($this->once())
             ->method('findById')
             ->with($id)
             ->willReturn($todo);

        $repo->expects($this->once())
             ->method('update')
             ->with($this->callback(function (Todo $t) use ($id) {
                 return $t->getId()->toString() === $id
                     && $t->isCompleted() === true;
             }));

        $useCase = new CompleteTodo($repo);
        $useCase->execute($id);
    }

    public function testShouldThrowWhenTodoNotFound()
    {
        $repo = $this->createMock(TodoRepository::class);
        $repo->method('findById')
             ->willReturn(null);

        $this->expectException(\DomainException::class);

        $useCase = new CompleteTodo($repo);
        $useCase->execute('non-existent-id');
    }
}
