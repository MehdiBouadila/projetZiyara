<?php 

namespace App\Controller;
use App\Entity\User; // Import your User entity
use Doctrine\ORM\EntityManagerInterface; // Import EntityManagerInterface
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;

class GoogleController extends AbstractController
{
    /**
     * @Route("/connect/google", name="connect_google_start")
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        // Redirect the user to Google for authentication
        return $clientRegistry
            ->getClient('google')
            ->redirect(['openid', 'email', 'profile']);
    }

    /**
     * @Route("/connect/google/check", name="connect_google_check")
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager)
    {
        // Retrieve the authenticated user data from Google
        $client = $clientRegistry->getClient('google');

        try {
            // Fetch the user details from Google
            $googleUser = $client->fetchUser();

            // Check if the user already exists in your database
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['googleId' => $googleUser->getId()]);

            if (!$existingUser) {
                // User does not exist, create a new User entity
                $user = new User();
                $user->setGoogleId($googleUser->getId()); // Set Google ID as the unique identifier
                $user->setEmail($googleUser->getEmail());
                $randomPassword = base64_encode(random_bytes(10));
                $user->setPassword($passwordEncoder->encodePassword($user, $randomPassword));
                // You can set other properties of the user entity here

                // Persist the new user entity
                $entityManager->persist($user);
                $entityManager->flush();

                // Authenticate the newly created user
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            } else {
                // User already exists, authenticate the user
                $token = new UsernamePasswordToken($existingUser, null, 'main', $existingUser->getRoles());
            }

            // Authenticate the user
            $authenticatedToken = $authenticationManager->authenticate($token);
            $tokenStorage->setToken($authenticatedToken);

            // Redirect to the desired page after login
            return $this->redirectToRoute('app_front');
        } catch (IdentityProviderException $e) {
            // Handle authentication errors
            $this->addFlash('error', 'Authentication failed. Please try again.');
            return $this->redirectToRoute('app_login');
        }
    }
}