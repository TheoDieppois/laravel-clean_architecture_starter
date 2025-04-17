<?php
namespace App\Application\Todo\Mappers;

use App\Application\Todo\DTO\TodoOutput;
use App\Domain\Todo\Entity\Todo;

final class TodoOutputMapper
{
    public static function toDto(Todo $todo): TodoOutput
    {
        return new TodoOutput(
            id:        $todo->getId()->toString(),
            title:     $todo->getTitle(),
            completed: $todo->isCompleted(),
            createdAt: $todo->getCreatedAt()->format(\DateTime::ATOM),
        );
    }
}
