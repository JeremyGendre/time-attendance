<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Serializer\Serializer;
use App\Service\Validator\ValidatorManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

abstract class BaseAbstractController extends AbstractController
{
    private ManagerRegistry $registry;
    private ValidatorManager $validatorManager;
    private Security $security;
    private Serializer $serializer;

    public function __construct(
        ManagerRegistry $registry,
        ValidatorManager $validatorManager,
        Security $security,
        Serializer $serializer
    ){
        $this->registry = $registry;
        $this->validatorManager = $validatorManager;
        $this->security = $security;
        $this->serializer = $serializer;
    }

    /**
     * @return JsonResponse
     */
    protected function basicSuccessResponse(): JsonResponse
    {
        return new JsonResponse(['success' => true]);
    }

    /**
     * @return User|null
     */
    protected function getUser(): ?User{
        /** @var User $user */
        $user = parent::getUser();
        return $user;
    }

    /**
     * @return ObjectManager
     */
    protected function getManager(): ObjectManager
    {
        return $this->registry->getManager();
    }

    /**
     * @return ValidatorManager
     */
    protected function getValidatorManager(): ValidatorManager
    {
        return $this->validatorManager;
    }

    /**
     * @return Security
     */
    protected function getSecurity(): Security
    {
        return $this->security;
    }

    /**
     * @return Serializer
     */
    protected function getSerializer(): Serializer
    {
        return $this->serializer;
    }
}
