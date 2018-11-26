<?php

namespace App\Form;

use App\Controller\BaseController;
use App\Entity\Department;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    protected $em;
    protected $user;
    private $bc;

    public function __construct(EntityManagerInterface $em, BaseController $bc)
    {
        $this->em = $em;
        $this->bc = $bc;
    }

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
                    'required' => true
                ]);
            if($options['password']){
                $builder->add('password', PasswordType::class,
                    [
                        'trim' => true,
                        'mapped' => false,
                        'label' => 'Пароль',
                        'required' => false
                    ]);
            } else {
                $builder->add('password', PasswordType::class,
                    [
                        'trim' => true,
                        'mapped' => false,
                        'label' => 'Пароль',
                        'required' => true
                    ]);
            }

            $builder->add('roles', ChoiceType::class,
                [
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Роль',
                    'choices' => [
//                        'Администратор' => 'ROLE_ADMIN',
                        'Менеджер' => 'ROLE_MANAGER',
                        'Мастер' => 'ROLE_MASTER',
                        'Курьер' => 'ROLE_COURIER',
                    ]
                ])
            ->add('department', EntityType::class,
                [
                    'label' => 'Филиал',
                    'class' => Department::class,
                    'required' => true,

                    // uses the User.username property as the visible option string
                    'choice_label' => 'address',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'password' => null
        ]);
    }
}
