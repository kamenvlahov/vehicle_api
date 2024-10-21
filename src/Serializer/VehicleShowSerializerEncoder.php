<?php

namespace App\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

class VehicleShowSerializerEncoder implements SerializerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize(mixed $data, string $format, array $context = []): string
    {
        return $this->serializer->serialize($data, 'json', [
            'groups' => ['vehicles:show']
        ]);
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {
        // TODO: Implement deserialize() method.
        return null;
    }
}