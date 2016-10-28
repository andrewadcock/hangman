<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\UserAccount;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserAccountData implements FixtureInterface, ContainerAwareInterface
{
    private $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    private function encodePassword($password)
    {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder(UserAccount::class);
        
        return $encoder->encodePassword($password, null);
    }
    public function load(ObjectManager $manager)
    {
        $user1 = new UserAccount(
          Uuid::fromString('7af4d9f9-00b0-41de-9b65-2cdb6b3d1b99'),
          'hhamon',
          $this->encodePassword('secret'),
          'Hugo Hamon',
          'hugo@example.com',
          '1987-07-02'
        );
        
        $user2 = new UserAccount(
          Uuid::fromString('e0bb4b91-0731-490f-80c5-90cd56aec003'),
          'tdale',
          $this->encodePassword('qwertyuiop'),
          'Tucker Dale',
          'tdale@example.com',
          '1990-10-25'
        );
        
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }
    
}