<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                        'Choose your logement type' => [
                            'Appartement' => 'Appartement',
                            'House' => 'Maison',
            ]]])
            ->add('address', TextType::class)
            ->add('cp', TextType::class)
            ->add('city', TextType::class)
            ->add('indoors', TextType::class)
            ->add('digicode', TextType::class)
            ->add('floor', TextType::class)
            ->add('elevator', ChoiceType::class, [
                'choices'  => [
                        'Does your housing have an elevator?' => [
                            'Yes_elevator' => 'Ascenseur disponible',
                            'No_elevator' => 'Pas d\'ascenseur',
            ]]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'translation_domain' => 'forms'
        ]);
    }
}
