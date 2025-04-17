<?php
namespace App\Infrastructure\Persistence\Todo\File;

use App\Domain\Todo\Entity\Todo;
use App\Domain\Todo\TodoRepository;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

final class FileTodoRepository implements TodoRepository
{
    private FilesystemAdapter $disk;
    private string $path = 'todos.json';

    public function __construct()
    {
        $this->disk = Storage::disk('local');

        if (! $this->disk->exists($this->path)) {
            $this->disk->put($this->path, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    private function readFile(): array
    {
        $content = $this->disk->get($this->path);

        return json_decode($content, true) ?: [];
    }

    private function writeFile(array $data): void
    {
        $this->disk->put($this->path, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function save(Todo $todo): void
    {
        $all = $this->readFile();

        $all['todos'][] = [
            'id'        => $todo->getId()->toString(),
            'title'     => $todo->getTitle(),
            'completed' => $todo->isCompleted(),
            'createdAt' => $todo->getCreatedAt()->format(\DateTime::ATOM),
        ];

        $this->writeFile($all);
    }

    /**
     * @return Todo[]
     */
    public function findAll(): array
    {
        $all = $this->readFile();

        return array_map(function(array $item) {
            return Todo::reconstruct(
                $item['id'],
                $item['title'],
                $item['completed'],
                new \DateTimeImmutable($item['createdAt'])
            );
        }, array_values($all['todos']));
    }

    public function findById(string $id): ?Todo
    {
        $all = $this->readFile();

        $filtered = array_find(
            $all['todos'],
            fn(array $item) => $item['id'] === $id
        );

        if (!$filtered) {
            return null;
        }

        return Todo::reconstruct(
            $filtered['id'],
            $filtered['title'],
            $filtered['completed'],
            new \DateTimeImmutable($filtered['createdAt'])
        );
    }

    public function update(Todo $todo): ?Todo
    {
        $all = $this->readFile();

        $filtered = array_find(
            $all['todos'],
            fn(array $item) => $item['id'] === $todo->getId()->toString()
        );

        if (!$filtered) {
            return null;
        }

        $filtered['title'] = $todo->getTitle();
        $filtered['completed'] = $todo->isCompleted();

        $all['todos'] = array_map(
            fn(array $item) => $item['id'] === $todo->getId()->toString() ? $filtered : $item,
            $all['todos']
        );

        $this->writeFile($all);

        return Todo::reconstruct(
            $filtered['id'],
            $filtered['title'],
            $filtered['completed'],
            new \DateTimeImmutable($filtered['createdAt'])
        );
    }


    public function delete(string $id): void
    {
        $all = $this->readFile();

        $filtered = array_filter(
            $all['todos'],
            fn(array $item) => $item['id'] !== $id
        );

        $all['todos'] = $filtered;

        $this->writeFile($all);
    }
}
