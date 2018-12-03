<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('info', TextareaType::class,
                [
                    'label' => false,
                    'required' => true,
                ])
            ->add('address', TextType::class,
                [
                    'label' => 'Адрес',
                    'required' => true,
                    'mapped' => false
                ])
            ->add('self_delivery', CheckboxType::class,
                [
                    'label'    => 'Доставка не требуется',
                    'required' => false,
                    'mapped' => false
                ])
            ->add('dueDate', DateTimeType::class,
                [
                    'label' => 'Время',
                    'required' => true,
                    'format' => 'dd-MM-yyyy HH:mm',
                ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}