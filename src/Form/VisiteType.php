<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;    


class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'] // Custom class for the title (label)
            ])
            ->add('descriptionVisite', null, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'] // Custom class for the title (label)
            ])
            
            ->add('dateVisite', null, [
                'attr' => ['class' => 'date-control'],
                'label_attr' => ['class' => 'date-label']
                 // Custom class for the title (label)
            ])
            ->add('prix', null, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'] // Custom class for the title (label)
            ])
            ->add('imagev', FileType::class, [
                'label' => 'Image', 
                'mapped' => false, 
                'required' => false, 
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'] // Custom class for the title (label)
            ])
            ->add('categorieVisite', null, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'] // Custom class for the title (label)
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
