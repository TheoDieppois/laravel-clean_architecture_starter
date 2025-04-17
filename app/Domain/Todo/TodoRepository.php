<?php
namespace App\Domain\Todo;

use App\Domain\Todo\Entity\Todo;

interface TodoRepository
{
    public function save(Todo $todo): void;

    /** @return Todo[] */
    public function findAll(): array;

    public function findById(string $id): ?Todo;

    public function update(Todo $todo): ?Todo;

    public function delete(string $id): void;
}
