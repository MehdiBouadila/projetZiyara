<?php

namespace App\Form;
use App\Entity\Guide;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;



class ReservationType extends AbstractType
{
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('dateReservationGuide')
                ->add('duree')
                ->add('guideId', HiddenType::class, [
                    'mapped' => false ,
                ])
                ->add('guide', EntityType::class, [
                    'class' => Guide::class,
                    'choice_label' => 'NomGuide',
                    'label' => ' ',
                    'multiple' => false,
                    'expanded' => false,
                    'attr' => ['style' => 'display:none;'], // Cache le champ
                ])
               ;
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
