<?php

namespace UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\User;
use UserBundle\Events;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class AuthenticationSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var string
     */
    private $firewallName;

    /**
     * AuthenticationSubscriber constructor.
     *
     * @param AuthenticationManagerInterface $authenticationManager
     * @param TokenStorageInterface          $tokenStorage
     * @param string                         $firewallName
     */
    public function __construct(AuthenticationManagerInterface $authenticationManager, TokenStorageInterface $tokenStorage, $firewallName)
    {
        $this->authenticationManager = $authenticationManager;
        $this->tokenStorage = $tokenStorage;
        $this->firewallName = $firewallName;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::USER_CREATED => 'authenticate'
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function authenticate(GenericEvent $event)
    {
        /** @var User $user */
        $user = $event->getSubject();

        $token = new UsernamePasswordToken($user, null, $this->firewallName, $user->getRoles());

        $authToken = $this->authenticationManager->authenticate($token);

        $this->tokenStorage->setToken($authToken);
    }
}