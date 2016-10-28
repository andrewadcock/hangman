<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users", uniqueConstraints={
 *  @UniqueConstraint(name="user_uuid_unique", columns="uuid"),
 *  @UniqueConstraint(name="user_nickname_unique", columns="nickname"),
 *  @UniqueConstraint(name="user_email_address_unique", columns="email_address")
 * })
 */
class UserAccount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="smallint", options={"unsigned": true})
     */
    private $id;
    
    /**
     * @ORM\Column(length=36)
     */
    private $uuid;
    
    /**
     * @ORM\Column(length=25)
     */
    private $nickname;
    
    /**
     * @ORM\Column
     */
    private $password;
    
    /**
     * @ORM\Column(length=50)
     */
    private $fullName;
    
    /**
     * @ORM\Column(length=100)
     */
    private $emailAddress;
    
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;
    
    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $permissions;
    
    /**
     * @ORM\Column(type="datetimetz")
     */
    private $registeredAt;
    
    public function __construct()
    {
        $this->registeredAt = new \DateTime();
        $this->permissions = ['ROLE_USER'];
    }
    
}