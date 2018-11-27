<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Название тикета',
                    ],
                ])
            ->add('info', TextareaType::class,
                [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'class' => 'ckeditor',
                    ],
                ])
            ->add('img', FileType::class, [
                'label' => 'Изображение',
                'required' => false
            ])
            ->add('dueDate', DateTimeType::class,
                [
                    'label' => 'Выполнить до',
                    'required' => true,
                    'format' => 'dd-MM-yyyy HH:mm',
                ])
            ->add('assignee', EntityType::class,
                [
                    'label' => 'Исполнитель',
                    'class' => User::class,
                    'choice_label' => 'fullInfo'
                ])
            ->add('department', EntityType::class,
                [
                    'label' => 'Филиал',
                    'class' => Department::class,
                    'choice_label' => 'address'
                ])

        ;
        $builder->get('img')->addModelTransformer(new CallbackTransformer(
            function($imageUrl) {
                return null;
            },
            function($imageUrl) {
                return $imageUrl;
            }
        ));
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
