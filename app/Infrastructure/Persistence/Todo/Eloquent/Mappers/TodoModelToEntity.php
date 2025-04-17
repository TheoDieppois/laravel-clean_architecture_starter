<?php
namespace App\Infrastructure\Persistence\Todo\Eloquent\Mappers;

use App\Domain\Todo\Entity\Todo;
use App\Infrastructure\Persistence\Todo\Eloquent\Models\TodoModel;

final class TodoModelToEntity
{
    public static function map(TodoModel $m): Todo
    {
        return Todo::reconstruct(
            id:        $m->id,
            title:     $m->title,
            completed: $m->completed,
            createdAt: $m->created_at instanceof \DateTimeImmutable
                ? $m->created_at
                : $m->created_at->toDateTimeImmutable(),
        );
    }
}
