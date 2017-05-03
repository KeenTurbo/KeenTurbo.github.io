<?php

namespace UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Event\UserEvent;
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
     * @param UserEvent                $event
     * @param string                   $eventName
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function authenticate(UserEvent $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        $user = $event->getUser();

        $token = new UsernamePasswordToken($user, null, $this->firewallName, $user->getRoles());

        $authToken = $this->authenticationManager->authenticate($token);

        $this->tokenStorage->setToken($authToken);

        $eventDispatcher->dispatch(Events::SECURITY_IMPLICIT_LOGIN, $event);
    }
}