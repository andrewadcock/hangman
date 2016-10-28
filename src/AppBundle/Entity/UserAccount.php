<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserAccountRepository")
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
    
    public function __construct(
      UuidInterface $uuid,
      $nickname,
      $password,
      $fullName,
      $emailAddress,
      $birthdate = null
    )
    {
        if(null != $birthdate && !$birthdate instanceof \DateTime) {
            $birthdate = new \DateTime($birthdate);
        }
        
        $this->registeredAt = new \DateTime();
        $this->permissions = ['ROLE_USER'];
        $this->uuid = $uuid;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->emailAddress = $emailAddress;
        $this->birthdate = $birthdate;
    }
    
    public static function signup(
      $nickname,
      $password,
      $fullName,
      $emailAddress,
      $birthdate = null
    ) {
        return new static(
          Uuid::uuid4(),
          $nickname,
          $password,
          $fullName,
          $emailAddress,
          $birthdate
        );
    }
    
    public function getUuid()
    {
        if (!$this->uuid instanceof UuidInterface) {
            $this->uuid = Uuid::fromString($this->uuid);
        }
        
        return $this->uuid;
    }
}