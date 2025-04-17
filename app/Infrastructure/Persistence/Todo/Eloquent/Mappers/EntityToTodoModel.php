<?php
namespace App\Infrastructure\Persistence\Todo\Eloquent\Mappers;

use App\Domain\Todo\Entity\Todo;
use App\Infrastructure\Persistence\Todo\Eloquent\Models\TodoModel;

final class EntityToTodoModel
{
    public static function map(Todo $todo): TodoModel
    {
        $model = new TodoModel();

        $model->setRawAttributes([
            'id'        => $todo->getId()->toString(),
            'title'     => $todo->getTitle(),
            'completed' => $todo->isCompleted(),
        ], /* syncOriginal = */ true);

        return $model;
    }
}
