<?php

namespace Tests\Unit\Mappers;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Persistence\Todo\Eloquent\Mappers\TodoModelToEntity;
use App\Infrastructure\Persistence\Todo\Eloquent\Models\TodoModel;
use App\Domain\Todo\Entity\Todo;
use Illuminate\Support\Carbon;

class TodoModelToEntityTest extends TestCase
{
    public function testShouldConvertModelToEntity()
    {
        $model = new TodoModel();
        $model->setRawAttributes([
            'id'         => '123e4567-e89b-12d3-a456-426614174000',
            'title'      => 'Un titre',
            'completed'  => true,
            'created_at' => Carbon::parse('2025-04-17 12:00:00', 'UTC'),
        ], /* sync = */ true);

        $todo = TodoModelToEntity::map($model);

        $this->assertInstanceOf(Todo::class, $todo);
        $this->assertSame($model->id, $todo->getId()->toString());
        $this->assertSame('Un titre', $todo->getTitle());
        $this->assertTrue($todo->isCompleted());

        $this->assertInstanceOf(\DateTimeImmutable::class, $todo->getCreatedAt());
        $expected = $model->created_at->toDateTimeImmutable()->format(\DateTime::ATOM);
        $this->assertEquals($expected, $todo->getCreatedAt()->format(\DateTime::ATOM));
    }
}
