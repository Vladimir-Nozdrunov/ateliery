<?php

namespace App\Form;

use App\Entity\Department;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', TextType::class,
                [
                    'label' => 'Адрес',
                    'required' => true,
                ])
            ->add('phone', TextType::class,
                [
                    'label' => 'Адрес',
                    'required' => true,
                ])
            ->add('openTime', TimeType::class,
                [
                    'label' => 'Адрес',
                    'required' => true,
                ])
            ->add('closeTime', TimeType::class,
                [
                    'label' => 'Адрес',
                    'required' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Department::class,
        ]);
    }
}
