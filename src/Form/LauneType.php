<?php

namespace App\Form;

use App\Entity\Laune;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Categories;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class LauneType extends AbstractType
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

            // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la base de données (mapped à false)
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('Valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Laune::class,
        ]);
    }
}
