<?php

namespace Tests\Unit\UseCases;

use PHPUnit\Framework\TestCase;
use App\Application\Todo\UseCases\CreateTodo;
use App\Application\Todo\DTO\CreateTodoInput;
use App\Application\Todo\DTO\TodoOutput;
use App\Domain\Todo\TodoRepository;

class CreateTodoTest extends TestCase
{
    public function testShouldSaveTodo()
    {
        $dto = new CreateTodoInput(title: 'Titre');

        $repo = $this->createMock(TodoRepository::class);
        $repo->expects($this->once())
             ->method('save');

        $useCase = new CreateTodo($repo);
        $useCase->execute($dto);
    }

    public function testShouldReturnDtoWithCorrectData()
    {
        $dto = new CreateTodoInput(title: 'Titre');

        $repo = $this->createMock(TodoRepository::class);
        $repo->expects($this->once())
            ->method('save');

        $useCase = new CreateTodo($repo);
        $output  = $useCase->execute($dto);

        $this->assertInstanceOf(TodoOutput::class, $output);
        $this->assertEquals($dto->title, $output->title);
        $this->assertFalse($output->completed);
        $this->assertNotEmpty($output->id);
        $this->assertMatchesRegularExpression(
            '/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/',
            $output->createdAt
        );
    }
}
