<?php

namespace App\Form;

use App\Entity\ReservationVisite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationVisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    ->add('dateReservationVisite', null, [
        'attr' => ['class' => 'date-control'],
        'label_attr' => ['class' => 'date-label'] // Custom class for the label
    ])
    ->add('nbrparticipantVisite', null, [
        'attr' => ['class' => 'form-control'],
        'label_attr' => ['class' => 'form-label'] // Custom class for the label
    ])
    ->add('idVisite', null, [
        'attr' => ['class' => 'form-control'],
        'label_attr' => ['class' => 'form-label'] // Custom class for the label
    ])
    ->add('nom', null, [
        'attr' => ['class' => 'form-control'],
        'label_attr' => ['class' => 'form-label'] // Custom class for the label
    ])
    ->add('prenom', null, [
        'attr' => ['class' => 'form-control'],
        'label_attr' => ['class' => 'form-label'] // Custom class for the label
    ])
    ->add('numtlph', null, [
        'attr' => ['class' => 'form-control'],
        'label_attr' => ['class' => 'form-label'] // Custom class for the label
    ])
    ->add('email', null, [
        'attr' => ['class' => 'form-control'],
        'label_attr' => ['class' => 'form-label'] // Custom class for the label
    ]);



            

           
            

            
            

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationVisite::class,
        ]);
    }
}
