<?php

namespace Tests\Unit\Mappers;

use PHPUnit\Framework\TestCase;
use App\Application\Todo\DTO\CreateTodoInput;
use App\Application\Todo\Mappers\TodoInputMapper;
use App\Domain\Todo\Entity\Todo;

class TodoInputMapperTest extends TestCase
{
    public function testShouldConvertDtoToEntity()
    {
        $dto = new CreateTodoInput(title: 'Mon titre de test');

        $todo = TodoInputMapper::toEntity($dto);

        $this->assertInstanceOf(Todo::class, $todo);
    }

    public function testShouldConvertDtoToEntityWithCorrectData()
    {
        $dto = new CreateTodoInput(title: 'Mon titre de test');

        $todo = TodoInputMapper::toEntity($dto);

        $this->assertEquals('Mon titre de test', $todo->getTitle());
        $this->assertFalse($todo->isCompleted());
        $this->assertInstanceOf(\DateTimeImmutable::class, $todo->getCreatedAt());
        $this->assertLessThan(
            5,
            (new \DateTimeImmutable())->getTimestamp()
            - $todo->getCreatedAt()->getTimestamp(),
            'Le createdAt doit être dans les 5 secondes précédentes'
        );
    }
}
