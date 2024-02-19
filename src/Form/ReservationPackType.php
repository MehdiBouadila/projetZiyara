<?php

namespace App\Form;

use App\Entity\Pack;
use App\Entity\ReservationPack;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationPackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('dateReservationPack', DateType::class, [
            //     'widget' => 'single_text',
            //     'html5' => false,
            //     'format' => 'yyyy-MM-dd',
            //     'attr' => [
            //         'class' => 'datepicker', // Assign a class for initialization with JS
            //     ],
            // ])
            ->add('dateReservationPack', null, [
                'widget' => 'single_text',
                'data' => $options['is_edit'] ? $options['data']->getDateReservationPack() : new \DateTime(),
            ])
            ->add('nbrParticipantPack')
            ->add('pack', EntityType::class, [
                'class' => Pack::class,
                'choice_label' => 'titrePack',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationPack::class,
            'is_edit' => false,
        ]);
    }
}
