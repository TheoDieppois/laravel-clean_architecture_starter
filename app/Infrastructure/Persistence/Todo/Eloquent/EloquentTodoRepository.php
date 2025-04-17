<?php

namespace App\Infrastructure\Persistence\Todo\Eloquent;

use App\Domain\Todo\Entity\Todo;
use App\Domain\Todo\TodoRepository;
use App\Infrastructure\Persistence\Todo\Eloquent\Models\TodoModel;
use App\Infrastructure\Persistence\Todo\Eloquent\Mappers\TodoModelToEntity;
use App\Infrastructure\Persistence\Todo\Eloquent\Mappers\EntityToTodoModel;

final class EloquentTodoRepository implements TodoRepository
{
    public function save(Todo $todo): void
    {
        $model = EntityToTodoModel::map($todo);
        $model->save();
    }

    /** @return Todo[] */
    public function findAll(): array
    {
        return TodoModel::all()
            ->map(fn(TodoModel $m) => TodoModelToEntity::map($m))
            ->all();
    }

    public function findById(string $id): ?Todo
    {
        $m = TodoModel::find($id);
        return $m ? TodoModelToEntity::map($m) : null;
    }

    public function update(Todo $todo): ?Todo
    {
        $m = TodoModel::find($todo->getId()->toString());
        if (!$m) {
            return null;
        }
        $m->title = $todo->getTitle();
        $m->completed = $todo->isCompleted();
        $m->save();

        return TodoModelToEntity::map($m);
    }

    public function delete(string $id): void
    {
        TodoModel::destroy($id);
    }
}
