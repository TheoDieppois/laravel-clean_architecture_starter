<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use App\Domain\Todo\ValueObject\TodoId;
use Ramsey\Uuid\Uuid;

class TodoIdTest extends TestCase
{
    public function testShouldGenerateValidUuid()
    {
        $id = TodoId::generate();
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $id->toString(),
            'Le format du UUID généré n’est pas valide'
        );
    }

    public function testShouldConvertFromStringAndToString()
    {
        $uuidString = Uuid::uuid4()->toString();
        $id1 = TodoId::fromString($uuidString);
        $id2 = TodoId::fromString($id1->toString());

        $this->assertEquals($uuidString, $id1->toString());
        $this->assertEquals($id1->toString(), $id2->toString());
    }

    public function testShouldBeEqualByValue()
    {
        $uuidString = Uuid::uuid4()->toString();
        $a = TodoId::fromString($uuidString);
        $b = TodoId::fromString($uuidString);

        $this->assertTrue($a->toString() === $b->toString(), 'Deux TodoId avec même chaîne doivent être égaux');
    }

    public function testShouldRejectInvalidUuid()
    {
        $this->expectException(\Ramsey\Uuid\Exception\InvalidUuidStringException::class);
        TodoId::fromString('not-a-uuid');
    }
}
