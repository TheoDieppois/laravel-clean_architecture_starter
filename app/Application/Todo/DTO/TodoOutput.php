<?php
namespace App\Application\Todo\DTO;

final class TodoOutput
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly bool $completed,
        public readonly string $createdAt
    ) {}
}
