<?php

namespace InfinitySystems\CalcBundle\Form;

use InfinitySystems\CalcBundle\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoneyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', EntityType::class, [
                'class' => Users::class,
                'placeholder' => 'Wybierz',
                'label' => 'Osoba:'
            ])
            ->add('amount', null, [
                'label' => 'Kwota:'
            ])
            ->add('monthYear', null, [
                'label' => 'Miesiąc i rok (format: MM.YYYY):'
            ])
            ->add('description', null, [
                'label' => 'Opis: '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'InfinitySystems\CalcBundle\Entity\Money'
        ]);
    }
}
