<?php


namespace App\Service\Ticking;


use App\Entity\Ticking;
use App\Entity\User;
use App\Repository\TickingRepository;
use App\Service\Utils\DateTime;
use DateTimeInterface;
use Exception;
use Symfony\Component\Security\Core\Security;

class TickingManager
{
    /**
     * @var TickingRepository
     */
    private $tickingRepository;
    /**
     * @var Security
     */
    private $security;

    public function __construct(TickingRepository $tickingRepository, Security $security)
    {
        $this->tickingRepository = $tickingRepository;
        $this->security = $security;
    }

    /**
     * @param User $user
     * @param DateTimeInterface $date
     * @return Ticking
     */
    public function getOrCreateTicking(User $user, DateTimeInterface $date): Ticking
    {
        $ticking = $this->tickingRepository->findOneBy(['user' => $user,'tickingDay' => $date]);
        if(!$ticking) {
            $ticking = new Ticking();
            $ticking->setUser($user)->setTickingDay($date);
        }
        return $ticking;
    }

    /**
     * @param User|null $user
     * @return Ticking
     * @throws Exception
     */
    public function getOrCreateTodayTicking(User $user = null): Ticking
    {
        $user = $user ?? $this->security->getUser();
        return $this->getOrCreateTicking($user, new DateTime());
    }
}
