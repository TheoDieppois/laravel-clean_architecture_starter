<?php
namespace App\Application\Todo\DTO;

final class CreateTodoInput
{
    public function __construct(
        public readonly string $title,
    ) {}
}
