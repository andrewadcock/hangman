<?php

namespace AppBundle\Contact;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

class ContactRequest
{
    /**
     * @Assert\NotBlank()
     * @Length(min=2, max=50)
     */
    public $fullName;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $emailAddress;
    
    /**
     * @Assert\NotBlank()
     * @Length(min=10)
     * @Assert\Regex(
     *     pattern="/(?:fuck|shit|bastard)/i",
     *     match = false,
     *     message="contact_request.message.bad_words"
     * )
     */
    public $message;
    
    /**
     * @Assert\NotBlank()
     * @Length(min=5, max=100)
     */
    public $subject;
    
    
}