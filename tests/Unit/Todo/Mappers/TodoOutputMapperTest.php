<?php

namespace Tests\Unit\Mappers;

use PHPUnit\Framework\TestCase;
use App\Domain\Todo\Entity\Todo;
use App\Application\Todo\Mappers\TodoOutputMapper;
use App\Application\Todo\DTO\TodoOutput;

class TodoOutputMapperTest extends TestCase
{
    public function testShouldConvertEntityToDto()
    {
        $todo  = Todo::create('Titre de test');

        $dto = TodoOutputMapper::toDto($todo);

        $this->assertInstanceOf(TodoOutput::class, $dto);
    }

    public function testShouldConvertEntityToDtoWithCorrectData()
    {
        $todo = Todo::create('Titre de test');
        $dto = TodoOutputMapper::toDto($todo);

        $this->assertEquals(
            $todo->getId()->toString(),
            $dto->id,
            'L’ID du DTO doit correspondre à celui de l’entité'
        );

        $this->assertEquals(
            'Titre de test',
            $dto->title,
            'Le titre du DTO doit correspondre à celui de l’entité'
        );

        $this->assertFalse(
            $dto->completed,
            'Le champ completed du DTO doit refléter l’état de l’entité'
        );

        $this->assertEquals(
            $todo->getCreatedAt()->format(\DateTime::ATOM),
            $dto->createdAt,
            'Le createdAt doit être formaté en DateTime::ATOM'
        );
    }
}
