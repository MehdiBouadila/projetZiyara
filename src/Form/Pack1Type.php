<?php

namespace App\Form;

use App\Entity\Guide;
use App\Entity\Pack;
use App\Entity\Transport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;



class Pack1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titrePack')
            ->add('descriptionPack')
            ->add('prixPack')
            ->add('imagePack', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => ['image/*'],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ]),
                ],
            ])
            // ->add('dateDepartPack', DateType::class, [
            //     'widget' => 'single_text',
            //     'html5' => false,
            //     'format' => 'yyyy-MM-dd',
            //     'attr' => [
            //         'class' => 'datepicker', // Assign a class for initialization with JS
            //     ],
            // ])
            ->add('dateDepartPack', null, [
                'widget' => 'single_text',
                'data' => $options['is_edit'] ? $options['data']->getDateDepartPack() : new \DateTime(),
            ])
            ->add('dateArrivePack', null, [
                'widget' => 'single_text',
                'data' => $options['is_edit'] ? $options['data']->getDateArrivePack() : new \DateTime(),
            ])
            // ->add('dateArrivePack', DateType::class, [
            //     'widget' => 'single_text',
            //     'html5' => false,
            //     'format' => 'yyyy/MM/dd',
            //     'attr' => [
            //         'class' => 'datepicker', // Assign a class for initialization with JS
            //     ],
            // ])
            ->add('transports', EntityType::class, [
                'class' => Transport::class,
                'choice_label' => 'prix_transport',
            ])
            ->add('guide', EntityType::class, [
                'class' => Guide::class,
                'choice_label' => 'nom_guide',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pack::class,
            'is_edit' => false,
        ]);
    }
}
