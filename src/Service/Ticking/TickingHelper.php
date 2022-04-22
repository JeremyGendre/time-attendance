<?php


namespace App\Service\Ticking;


use App\Entity\Ticking;
use App\Service\Serializer\Serializer;
use App\Service\Serializer\TimeSerializerHelper;
use Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class TickingHelper
{
    /**
     * @param Ticking $ticking
     * @param Serializer $serializer
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     */
    public static function normalizeTicking(Ticking $ticking, Serializer $serializer)
    {
        $result = $serializer->normalize($ticking, null, [
            'groups' => 'main',
            DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i',
        ]);
        return TimeSerializerHelper::normalizeTimeAttributes($result);
    }

    /**
     * @param $tickings
     * @param Serializer $serializer
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     */
    public static function normalizeManyTickings($tickings, Serializer $serializer)
    {
        $result = $serializer->normalizeMany($tickings, null, [
            'groups' => 'main',
            DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i',
        ]);
        return TimeSerializerHelper::normalizeTimeAttributes($result);
    }
}
