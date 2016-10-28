<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserAccountRepository")
 * @ORM\Table(name="users", uniqueConstraints={
 *  @UniqueConstraint(name="user_uuid_unique", columns="uuid"),
 *  @UniqueConstraint(name="user_nickname_unique", columns="nickname"),
 *  @UniqueConstraint(name="user_email_address_unique", columns="email_address")
 * })
 *
 * @UniqueEntity("nickname", groups="Signup")
 * @UniqueEntity("emailAddress")
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
     * @Assert\NotBlank(groups="Signup")
     * @Assert\Length(min=6, max=25, groups="Signup")
     * @Assert\Regex("/^[a-z0-9]+$/i", groups="Signup")
     */
    private $nickname;
    
    /**
     * @ORM\Column
     *
     * @Assert\NotBlank(groups="Signup")
     * @Assert\Length(min=8)
     */
    private $password;
    
    /**
     * @ORM\Column(length=50)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=50)
     */
    private $fullName;
    
    /**
     * @ORM\Column(length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $emailAddress;
    
    /**
     * @ORM\Column(type="date", nullable=true)
     *
     * @Assert\NotBlank(groups="Signup")
     * @Assert\Range(max="-18 years", maxMessage="user_account.birthdate.must_be_adult")
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
    ) {
        if (null != $birthdate && !$birthdate instanceof \DateTime) {
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
    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getNickname()
    {
        return $this->nickname;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getFullName()
    {
        return $this->fullName;
    }
    
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
    
    public function getBirthdate()
    {
        return $this->birthdate;
    }
    
    /**
     * @Assert\Callback()
     */
    public static function checkPassword(
      self $account,
      ExecutionContextInterface $context
    ) {
        if (false !== stripos($account->password, $account->nickname)) {
            $context
              ->buildViolation('user_account.password.nickname_detected')
              ->atPath('password')
              ->setParameter('{{ nickname }}', $account->nickname)
              ->setParameter('{{ password }}', $account->password)
              ->addViolation();
        }
    }
}