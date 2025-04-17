<?php
namespace App\Application\Todo\Mappers;

use App\Application\Todo\DTO\CreateTodoInput;
use App\Domain\Todo\Entity\Todo;

final class TodoInputMapper
{
    public static function toEntity(CreateTodoInput $dto): Todo
    {
        return Todo::create(
            $dto->title
        );
    }
}
