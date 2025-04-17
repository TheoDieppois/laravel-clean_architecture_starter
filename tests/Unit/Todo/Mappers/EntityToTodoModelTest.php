<?php

namespace Tests\Unit\Mappers;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Persistence\Todo\Eloquent\Mappers\EntityToTodoModel;
use App\Infrastructure\Persistence\Todo\Eloquent\Models\TodoModel;
use App\Domain\Todo\Entity\Todo;

class EntityToTodoModelTest extends TestCase
{
    public function testMapCreatesModelWithCorrectAttributes(): void
    {
        $title = 'Mapping Test';
        $todo  = Todo::create($title);

        $model = EntityToTodoModel::map($todo);

        $this->assertInstanceOf(TodoModel::class, $model);

        $this->assertSame($todo->getId()->toString(), $model->id);
        $this->assertSame('Mapping Test', $model->title);
        $this->assertFalse($model->completed);
    }
}
