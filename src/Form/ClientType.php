<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,
                [
                    'label' => 'Почта',
                    'required' => true
                ])
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
                    'required' => true,
                    'attr' => [
                        'placeholder' => '(099)123-45-67'
                    ]
                ])
            ->add('address', TextType::class,
                [
                    'label' => 'Адрес',
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Леси Украинки 26'
                    ]
                ])
            ->add('password', PasswordType::class,
                [
                    'trim' => true,
                    'mapped' => false,
                    'label' => 'Пароль',
                    'required' => false
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
