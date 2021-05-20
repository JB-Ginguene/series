<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('overview', TextareaType::class,
                [
                    'required' => false,
                    'label' => 'Description'
                ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Cancelled' => 'cancelled',
                    'Ended' => 'ended',
                    'Returning' => 'returning'
                ],
                'multiple' => false
            ])
            ->add('vote')
            ->add('popularity')
            ->add('genres', ChoiceType::class, [
                'choices' => [
                    'Drama' => 'drama',
                    'Romance' => 'romance',
                    'Horror' => 'horror',
                    'Musical' => 'musical'
                ],
                'expanded' => true,
                'multiple' => true
            ])
            ->add('firstAirDate', DateType::class)
            ->add('lastAirDate', DateType::class, [
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('backdrop')
            ->add('poster')
            ->add('tmdbId');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
