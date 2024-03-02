<?php

namespace App\Controller;

use App\Service\SmsGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmsController extends AbstractController
{
   
    //La vue du formulaire d'envoie du sms
    #[Route('/send', name: 'send_home')]
    public function index(): Response
    {
        return $this->render('front/transport/sms.html.twig',['smsSent'=>false]);
    }

    //Gestion de l'envoie du sms
    #[Route('/sendSms', name: 'send_sms', methods: ['GET', 'POST'])]
public function sendSms(Request $request, SmsGenerator $smsGenerator): Response
{
    $number = $request->request->get('number');
    $number_test = $_ENV['twilio_to_number']; // Numéro vérifié par Twilio. Un seul numéro autorisé pour la version de test.

    // Appel du service
    $smsGenerator->sendSms($number_test, '', ''); // Passing empty strings for $name and $text

    return $this->render('front/transport/sms.html.twig', ['smsSent' => true]);
}
}