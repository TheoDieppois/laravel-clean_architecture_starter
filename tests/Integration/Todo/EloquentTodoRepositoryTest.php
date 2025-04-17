<?php

namespace Tests\Integration\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructure\Persistence\Todo\Eloquent\EloquentTodoRepository;
use App\Domain\Todo\Entity\Todo;

class EloquentTodoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldCreateTodo(): void
    {
        // Récupère l’implémentation Eloquent du repository
        /** @var EloquentTodoRepository $repo */
        $repo = $this->app->make(EloquentTodoRepository::class);

        $todo = Todo::create('Intégration 1');
        $repo->save($todo);

        $this->assertNotNull($todo);
        $this->assertSame('Intégration 1', $todo->getTitle());
    }

    public function testShouldFindAllTodos(): void
    {
        // Récupère l’implémentation Eloquent du repository
        /** @var EloquentTodoRepository $repo */
        $repo = $this->app->make(EloquentTodoRepository::class);

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
        // Récupère l’implémentation Eloquent du repository
        /** @var EloquentTodoRepository $repo */
        $repo = $this->app->make(EloquentTodoRepository::class);

        $todo = Todo::create('Intégration 1');
        $repo->save($todo);

        $found = $repo->findById($todo->getId()->toString());
        $this->assertNotNull($found);
        $this->assertSame($todo->getId()->toString(), $found->getId()->toString());
        $this->assertSame('Intégration 1', $found->getTitle());
    }

    public function testShouldMarkTodoAsCompleted(): void
    {
        // Récupère l’implémentation Eloquent du repository
        /** @var EloquentTodoRepository $repo */
        $repo = $this->app->make(EloquentTodoRepository::class);

        $todo = Todo::create('Intégration 1');
        $repo->save($todo);

        $todo->markAsCompleted();
        $repo->update($todo);

        $updated = $repo->findById($todo->getId()->toString());
        $this->assertTrue($updated->isCompleted());
    }

    public function testShouldDeleteTodo(): void
    {
        $repo = $this->app->make(EloquentTodoRepository::class);

        $todo = Todo::create('Intégration 1');
        $repo->save($todo);

        $repo->delete($todo->getId()->toString());

        $this->assertNull($repo->findById($todo->getId()->toString()));
    }
}
