<?php

namespace App\Form;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CheckoutType extends AbstractType
{
    public function __construct(Security $security, AddressRepository $repo)
    {
        $this->security = $security;
        $this->repo = $repo;
    }

    public function choices()
    {
        $user = $this->security->getUser();
        $getAddress = $this->repo->findAllAddressById($user->getId());
        $index = -1;
        $address = [];
        foreach($getAddress as &$value)
        {
            $index ++;
            array_push($address, [
            $value->getFirstname() . ' ' . $value->getLastname() . ' - ' . $value->getAddress() . ' ' . $value->getCp() => $value->getId()
            ]);
        }
        return $address;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('delivery_address', ChoiceType::class, [
                'choices' => $this->choices()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'forms'
        ]);
    }
}
