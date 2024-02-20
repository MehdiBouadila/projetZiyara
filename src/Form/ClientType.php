<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomClient', null, [
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 5,'max' => 25]),
                new Regex(['pattern' => '/^[a-zA-Z\s]+$/']),
            ],
        ])
        ->add('prenomClient', null, [
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 5,'max' => 25]),
                new Regex(['pattern' => '/^[a-zA-Z\s]+$/']),
            ],
        ])
        ->add('emailClient', null, [
            'constraints' => [
                new NotBlank(),
                new Email(),
            ],
        ])
        ->add('mdpClient', null, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                    'message' => 'Your password must be at least 8 characters long, and include at least one lowercase letter, one uppercase letter, one number, and one special character.',
                ]),
            ],
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
