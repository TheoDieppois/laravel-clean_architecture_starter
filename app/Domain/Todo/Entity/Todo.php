<?php
namespace App\Domain\Todo\Entity;

use App\Domain\Todo\ValueObject\TodoId;

final class Todo
{
    private TodoId $id;
    private string $title;
    private bool $completed;
    private \DateTimeImmutable $createdAt;

    private function __construct(
        TodoId $id,
        string $title,
        bool $completed,
        \DateTimeImmutable $createdAt
    ) {
        $this->id        = $id;
        $this->title     = $title;
        $this->completed = $completed;
        $this->createdAt = $createdAt;
    }

    public static function create(string $title): self
    {
        return new self(
            TodoId::generate(),
            $title,
            false,
            new \DateTimeImmutable()
        );
    }

    public static function reconstruct(
        string $id,
        string $title,
        bool $completed,
        \DateTimeImmutable $createdAt
    ): self {
        return new self(
            TodoId::fromString($id),
            $title,
            $completed,
            $createdAt
        );
    }

    public function markAsCompleted(): void
    {
        $this->completed = true;
    }

    public function getId(): TodoId
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
