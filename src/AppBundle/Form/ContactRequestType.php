<?php

namespace AppBundle\Form;

use AppBundle\Contact\ContactRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('fullName', TextType::class)
          ->add(
            'emailAddress',
            EmailType::class,
            [
              'attr' => [
                'placeholder' => 'you@example.org',
              ],
            ]
          )
          ->add('subject', TextType::class)
          ->add(
            'message',
            TextareaType::class,
            [
              'attr' => [
                'cols' => 70,
                'rows' => 15,
              ],
            ]
          );
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
          [
            // Override to check for the correct type.
            'data_class' => ContactRequest::class,
            // Rename CSRF name to rename _token field name.
            'csrf_field_name' => 'hash',
          ]
        );
        
        
    }
}
