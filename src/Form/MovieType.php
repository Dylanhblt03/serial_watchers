<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\Director;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('releaseYear')
            ->add('genre')
            ->add('synopsis')
            ->add('director', EntityType::class, [
                'class' => Director::class,
                'choice_label' => function(Director $director) {
                    return $director->getFirstName() . ' ' . $director->getLastName();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
