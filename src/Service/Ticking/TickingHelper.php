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
     * @param string $groups
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     */
    public static function normalizeTicking(Ticking $ticking, Serializer $serializer, string $groups = 'main')
    {
        $result = $serializer->normalize($ticking, null, [
            'groups' => $groups,
            DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i',
        ]);
        return TimeSerializerHelper::normalizeTimeAttributes($result);
    }

    /**
     * @param $tickings
     * @param Serializer $serializer
     * @param string $groups
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     */
    public static function normalizeManyTickings($tickings, Serializer $serializer, string $groups = 'main')
    {
        $result = $serializer->normalizeMany($tickings, null, [
            'groups' => $groups,
            DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i',
        ]);
        return TimeSerializerHelper::normalizeTimeAttributes($result);
    }
}
