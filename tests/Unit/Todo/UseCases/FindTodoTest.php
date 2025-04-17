<?php

namespace Tests\Unit\UseCases;

use PHPUnit\Framework\TestCase;
use App\Application\Todo\UseCases\FindTodo;
use App\Domain\Todo\TodoRepository;
use App\Domain\Todo\Entity\Todo;
use App\Application\Todo\DTO\TodoOutput;
class FindTodoTest extends TestCase
{
    public function testShouldFindTodo()
    {
        $id   = '123e4567-e89b-12d3-a456-426614174000';
        $repo = $this->createMock(TodoRepository::class);
        $repo->expects($this->once())
             ->method('findById');

        $useCase = new FindTodo($repo);
        $useCase->execute($id);
    }

    public function testShouldReturnNullIfTodoNotFound()
    {
        $id   = '123e4567-e89b-12d3-a456-426614174000';
        $repo = $this->createMock(TodoRepository::class);
        $repo->expects($this->once())
             ->method('findById')
             ->willReturn(null);

        $useCase = new FindTodo($repo);
        $result = $useCase->execute($id);

        $this->assertNull($result);
    }

    public function testShouldReturnTodoOutput()
    {
        $id   = '123e4567-e89b-12d3-a456-426614174000';
        $repo = $this->createMock(TodoRepository::class);
        $repo->expects($this->once())
             ->method('findById')
             ->willReturn(Todo::create('Test'));

        $useCase = new FindTodo($repo);
        $result = $useCase->execute($id);

        $this->assertInstanceOf(TodoOutput::class, $result);
    }
}
