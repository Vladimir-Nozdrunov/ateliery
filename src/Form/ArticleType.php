<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Заголовок',
                    ],
                ])
//            ->add('createdAt')
            ->add('introText', TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Аннотация',
                    ],
                ])
            ->add('content', TextareaType::class,
                [
                    'label' => false,
                    'attr' => [
                        'class' => 'ckeditor',
                        'placeholder' => 'Полная информация',
                    ],
                ])
            ->add('previewImg', FileType::class, [
                'label' => 'Изображение для превью',
                'required' => false
            ])
            ->add('isPublished', ChoiceType::class,
                [
                    'choices' => ['Да' => true, 'Нет' => false],
                    'label' => 'Опубликована'
                ]);
        $builder->get('previewImg')->addModelTransformer(new CallbackTransformer(
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
            'data_class' => Article::class,
        ]);
    }
}
