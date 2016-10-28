<?php

namespace AppBundle\Form;

use AppBundle\Entity\UserAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('fullName', TextType::class)
          ->add('nickname', TextType::class)
          ->add(
            'password',
            RepeatedType::class,
            [
              'type' => PasswordType::class,
            ]
          )
          ->add(
            'emailAddress',
            EmailType::class,
            [
              'property_path' => 'emailAddress',
            ]
          )
          ->add(
            'birthdate',
            BirthdayType::class,
            [
              'required' => false,
            ]
          )
          ->add(
            'rules',
            CheckboxType::class,
            [
              'required' => false,
              'mapped' => false,
            ]
          );
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults(
          [
            'data_class' => UserAccount::class,
            'empty_data' => function (FormInterface $form) {
                return UserAccount::signup(
                  $form->get('nickname')->getData(),
                  $form->get('password')->getData(),
                  $form->get('fullName')->getData(),
                  $form->get('emailAddress')->getData(),
                  $form->get('birthdate')->getData()
                );
            },
            'with_rules' => true,
            'translation_domain' => "registration",
            'validation_groups' => ['Signup', Constraint::DEFAULT_GROUP],
          ]
        );
    }
    
}
