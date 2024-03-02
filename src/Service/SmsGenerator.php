<?php
// src/Service/MessageGenerator.php
namespace App\Service;

use Twilio\Rest\Client;

class SmsGenerator
{
    public function sendSms(string $number)
{
    $accountSid = $_ENV['twilio_account_sid'];      // Identifiant du compte Twilio
    $authToken = $_ENV['twilio_auth_token'];         // Token d'authentification
    $fromNumber = $_ENV['twilio_from_number'];       // Numéro de test d'envoi SMS offert par Twilio

    $toNumber = $number;                             // Le numéro de la personne qui reçoit le message
    $message = 'Reservation Confirme.';      // Message fixe (without name and text)

    // Client Twilio pour la création et l'envoi du SMS
    $client = new Client($accountSid, $authToken);

    $client->messages->create(
        $toNumber,
        [
            'from' => $fromNumber,
            'body' => $message,
        ]
    );
}

}