<?php

namespace Tests\Unit\UseCases;

use PHPUnit\Framework\TestCase;
use App\Application\Todo\UseCases\ListTodos;
use App\Application\Todo\DTO\TodoOutput;
use App\Domain\Todo\TodoRepository;
use App\Domain\Todo\Entity\Todo;

class ListTodosTest extends TestCase
{
    public function testShouldListTodos()
    {
        $t1 = Todo::create('tâche 1');
        $t2 = Todo::create('tâche 2');

        $repo = $this->createMock(TodoRepository::class);
        $repo->expects($this->once())
             ->method('findAll')
             ->willReturn([$t1, $t2]);

        $useCase = new ListTodos($repo);
        $useCase->execute();
    }

    public function testShouldReturnMappedTodoOutputs()
    {
        $t1 = Todo::create('tâche 1');
        $t2 = Todo::create('tâche 2');

        $repo = $this->createMock(TodoRepository::class);
        $repo->method('findAll')
             ->willReturn([$t1, $t2]);

        $useCase = new ListTodos($repo);
        $result  = $useCase->execute();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(TodoOutput::class, $result[0]);
        $this->assertEquals('tâche 1', $result[0]->title);
        $this->assertEquals('tâche 2', $result[1]->title);
    }
}
