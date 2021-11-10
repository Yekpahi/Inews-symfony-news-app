<?php

namespace App\Form;

use App\Entity\VideoPost;
use App\Entity\Categories;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VideoPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('content', CKEditorType::class)
            ->add('categories', EntityType::class, [
                'class' => Categories::class
            ])
            ->add('active', CheckboxType::class)
            ->add('file')
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    " " => 0,
                    'Urgent' => 1,
                    'Bonheur' => 2,
                    'Triste' => 3,
                ],
                'choice_attr' => [
                    'Urgent' => ['data-color' => 'Red'],
                    'Bonheur' => ['data-color' => 'blue'],
                    'Triste' => ['data-color' => 'black'],
                ],
            ])
            ->add('videoPicsFile', FileType::class, [
                'required' => true
            ])

            ->add('Valider', SubmitType::class);
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VideoPost::class,
        ]);
    }
}
