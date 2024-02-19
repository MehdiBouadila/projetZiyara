<?php

namespace App\Form;

use App\Entity\CategorieVisite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieVisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomCategorie', null, [
            'attr' => ['class' => 'form-control'],
            'label_attr' => ['class' => 'form-label'] // Custom class for the title (label)
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieVisite::class,
        ]);
    }
}
