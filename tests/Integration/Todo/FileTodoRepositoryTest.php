<?php

namespace Tests\Integration\Repositories;

use Tests\TestCase;
use App\Domain\Todo\Entity\Todo;
use App\Infrastructure\Persistence\Todo\File\FileTodoRepository;
use Illuminate\Support\Facades\Storage;

class FileTodoRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function testShouldCreateTodo(): void
    {
        $repo = $this->app->make(FileTodoRepository::class);

        $todo = Todo::create('Intégration 1');
        $repo->save($todo);

        $found = $repo->findById($todo->getId()->toString());
        $this->assertNotNull($found);
        $this->assertEquals($todo->getTitle(), $found->getTitle());
    }

    public function testShouldFindAllTodos(): void
    {
        $repo = $this->app->make(FileTodoRepository::class);

        $todo1 = Todo::create('Intégration 1');
        $todo2 = Todo::create('Intégration 2');

        $repo->save($todo1);
        $repo->save($todo2);

        $all = $repo->findAll();
        $this->assertCount(2, $all);
        $this->assertSame($todo1->getId()->toString(), $all[0]->getId()->toString());
        $this->assertSame($todo2->getId()->toString(), $all[1]->getId()->toString());
    }

    public function testShouldFindById(): void
    {
        $repo = $this->app->make(FileTodoRepository::class);

        $todo = Todo::create('À trouver');
        $repo->save($todo);

        $found = $repo->findById($todo->getId()->toString());
        $this->assertNotNull($found);
        $this->assertEquals($todo->getTitle(), $found->getTitle());
    }

    public function testShouldMarkTodoAsCompleted(): void
    {
        $repo = $this->app->make(FileTodoRepository::class);

        $todo = Todo::create('À compléter');
        $repo->save($todo);

        $todo->markAsCompleted();
        $repo->update($todo);

        $updated = $repo->findById($todo->getId()->toString());
        $this->assertTrue($updated->isCompleted());
    }

    public function testShouldDeleteTodo(): void
    {
        $repo = $this->app->make(FileTodoRepository::class);

        $todo = Todo::create('À supprimer');
        $repo->save($todo);

        // findById
        $found = $repo->findById($todo->getId()->toString());
        $this->assertNotNull($found);
        $this->assertEquals($todo->getTitle(), $found->getTitle());

        //delete
        $repo->delete($todo->getId()->toString());
        $this->assertNull($repo->findById($todo->getId()->toString()));
    }
}
