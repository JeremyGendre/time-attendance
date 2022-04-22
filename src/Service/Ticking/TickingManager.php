<?php


namespace App\Service\Ticking;


use App\Entity\Ticking;
use App\Entity\User;
use App\Repository\TickingRepository;
use App\Service\Utils\DateTime;
use DateInterval;
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
     * @param bool $flushOnCreate
     * @return Ticking
     */
    public function getOrCreateTicking(User $user, DateTimeInterface $date, bool $flushOnCreate = false): Ticking
    {
        $ticking = $this->tickingRepository->findOneBy(['user' => $user,'tickingDay' => $date]);
        if(!$ticking) {
            $ticking = new Ticking();
            $ticking->setUser($user)->setTickingDay($date);
            if($flushOnCreate){
                $this->tickingRepository->add($ticking, true);
            }
        }
        return $ticking;
    }

    /**
     * @param User|null $user
     * @param bool $flushOnCreate
     * @return Ticking
     * @throws Exception
     */
    public function getOrCreateTodayTicking(User $user = null, bool $flushOnCreate = false): Ticking
    {
        $user = $user ?? $this->security->getUser();
        return $this->getOrCreateTicking($user, new DateTime(), $flushOnCreate);
    }

    /**
     * @param User|null $user
     * @param DateTimeInterface|null $date
     * @return mixed
     * @throws Exception
     */
    public function getUserTickingHistory(User $user = null, DateTimeInterface $date = null)
    {
        if(!$user) $user = $this->security->getUser();
        if(!$date) $date = new DateTime();
        $weekBefore = (clone $date)->sub(new DateInterval('P7D'));
        return $this->tickingRepository->getUserHistory($user, $weekBefore, $date);
    }
}
