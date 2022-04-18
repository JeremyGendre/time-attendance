<?php

namespace App\Service\Serializer;

use ArrayObject;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class Serializer
{
    private SerializerInterface $serializer;
    private ObjectNormalizer $normalizer;

    public function __construct(SerializerInterface $serializer, ObjectNormalizer $normalizer)
    {
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
    }

    /**
     * @param $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|mixed|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []): mixed
    {
        return $this->normalizer->normalize($object, $format, $context);
    }

    /**
     * @param $objects
     * @param string|null $format
     * @param array $options
     * @return array
     * @throws ExceptionInterface
     */
    public function normalizeMany($objects, string $format = null, array $options = []): array
    {
        $result = [];
        foreach ($objects as $object){
            $result[] = $this->normalize($object, $format, $options);
        }
        return $result;
    }

    /**
     * @param $objects
     * @return array
     */
    public static function serializeManyFromInnerMethod($objects): array
    {
        $result = [];
        foreach ($objects as $object) {
            $result[] = $object->serialize();
        }
        return $result;
    }

    /**
     * @param $data
     * @param string $format
     * @param array $context
     * @return string
     */
    public function serialize($data, string $format, array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    /**
     * @param $data
     * @param string $type
     * @param string $format
     * @param array $context
     * @return mixed
     */
    public function deserialize($data, string $type, string $format, array $context = []): mixed
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}
