<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use App\Domain\Todo\Entity\Todo;
use App\Domain\Todo\ValueObject\TodoId;

class TodoTest extends TestCase
{
    public function testShouldCreateTodoWithCorrectData()
    {
        $title = 'Faire les courses';
        $todo  = Todo::create($title);

        $this->assertMatchesRegularExpression(
            '/' . TodoId::fromString($todo->getId()->toString())->toString() . '/',
            $todo->getId()->toString()
        );
        $this->assertEquals('Faire les courses', $todo->getTitle());
        $this->assertFalse($todo->isCompleted());
        $this->assertInstanceOf(\DateTimeImmutable::class, $todo->getCreatedAt());
        $this->assertLessThan(
            5,
            (new \DateTimeImmutable())->getTimestamp() - $todo->getCreatedAt()->getTimestamp()
        );
    }

    public function testShouldReconstructTodoWithCorrectData()
    {
        $id = TodoId::generate()->toString();
        $title = 'Écrire un test';
        $completed = true;
        $createdAt = new \DateTimeImmutable('2025-04-01T12:34:56+00:00');

        $todo = Todo::reconstruct(
            $id,
            $title,
            $completed,
            $createdAt
        );

        $this->assertEquals($id, $todo->getId()->toString());
        $this->assertEquals($title, $todo->getTitle());
        $this->assertTrue($todo->isCompleted());
        $this->assertEquals($createdAt, $todo->getCreatedAt());
    }

    public function testShouldMarkAsCompleted()
    {
        $todo = Todo::create('Faire la vaisselle');
        $this->assertFalse($todo->isCompleted());

        $todo->markAsCompleted();
        $this->assertTrue($todo->isCompleted());
    }

    public function testShouldHaveUniqueIds()
    {
        $todo1 = Todo::create('Tâche 1');
        $todo2 = Todo::create('Tâche 2');

        $this->assertNotEquals(
            $todo1->getId()->toString(),
            $todo2->getId()->toString(),
            'Chaque Todo créé doit avoir un ID différent'
        );
    }
}
