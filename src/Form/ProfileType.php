<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ProfileType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => false
            ])
            ->add('lastname', TextType::class, [
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'required' => false
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'empty_data' => $this->security->getUser()->getPassword()
            ])
            ->add('confirmPassword', PasswordType::class, [
                'required' => false,
                'empty_data' => $this->security->getUser()->getPassword()
            ])
            ->add('phone', TelType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
            'translation_domain' => 'forms'
        ]);
    }
}
