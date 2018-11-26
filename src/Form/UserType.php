<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('firstName', TextType::class,
                [
                    'label' => 'Имя',
                    'required' => true
                ])
            ->add('lastName', TextType::class,
                [
                    'label' => 'Фамилия',
                    'required' => true
                ])
            ->add('phone', TextType::class,
                [
                    'label' => 'Телефон',
                    'required' => true
                ])
            ->add('password', PasswordType::class,
                [
                    'trim' => true,
                    'mapped' => false,
                    'label' => 'Пароль',
                ])
            ->add('roles', ChoiceType::class,
                [
                    'mapped' => false,
                    'label' => 'Роль',
                    'choices' => [
                        'Администратор' => 'ROLE_ADMIN',
                        'Менеджер' => 'ROLE_MANAGER',
                        'Сотрудник' => 'ROLE_WORKER',
                        'Курьер' => 'ROLE_COURIER',
                    ]
                ])
            ->add('department', EntityType::class,
                [
                    'label' => 'Филиал',
                    'class' => Department::class,

                    // uses the User.username property as the visible option string
                    'choice_label' => 'address',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
