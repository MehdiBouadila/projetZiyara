<?php

namespace App\Form;

use App\Entity\ReservationTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Transport;

class ReservationTransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idUser')
            ->add('idTransport', EntityType::class, [
                'class' => Transport::class,
                'choice_label' => 'id', 
            ])
            ->add('dateReservationTransport')
            ->add('pointDepart')
            ->add('pointArrive')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationTransport::class,
        ]);
    }
}
