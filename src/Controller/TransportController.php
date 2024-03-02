<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use App\Repository\TransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/transport')]
class TransportController extends AbstractController
{
    #[Route('/', name: 'app_transport_index', methods: ['GET'])]
    public function index(TransportRepository $transportRepository): Response
    {
        return $this->render('back/transport/index.html.twig', [
            'transports' => $transportRepository->findAll(),
        ]);
    }

    #[Route('/f', name: 'app_transport_index_f', methods: ['GET'])]
    public function indexf(TransportRepository $transportRepository): Response
    {
        return $this->render('front/transport/indext.html.twig', [
            'transports' => $transportRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_transport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $file = $form->get('imageTransport')->getData();
            if ($file) {
                $fileName = uniqid().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('images_directory'), 
                    $fileName
                );
                $transport->setImageTransport($fileName);
            }

            $entityManager->persist($transport);
            $entityManager->flush();

            return $this->redirectToRoute('app_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/transport/new.html.twig', [
            'transports' => $transport,
            'form' => $form,
        ]);
        
    }
    #[Route('/transport/{id}', name: 'app_transport_show', methods: ['GET'])]
    public function show(Transport $transport): Response
    {
        return $this->render('back/transport/show.html.twig', [
            'transport' => $transport,
        ]);
    }
   
    #[Route('/transportf/{id}', name: 'app_transport_show_front', methods: ['GET'])]
    public function showfront(Transport $transport): Response
    {
        return $this->render('front/transport/show.html.twig', [
            'transport' => $transport,
        ]);
    }

#[Route('/{id}/edit', name: 'app_transport_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Transport $transport, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(TransportType::class, $transport);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload
        $imageFile = $form->get('imageTransport')->getData();

        if ($imageFile instanceof UploadedFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('images_directory'), // Directory where files should be uploaded
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle file upload error
            }

            // Update the imageTransport property with the new filename
            $transport->setImageTransport($newFilename);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_transport_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('back/transport/edit.html.twig', [
        'transport' => $transport,
        'form' => $form,
    ]);
}
    #[Route('/order-by-date', name: 'order_by_date',methods: ['GET'])]
    public function orderByDate(TransportRepository $transportRepository): Response
    {
        $transports = $transportRepository->order_By_Date();

        // Render your template with the sorted list of transports
        return $this->render('front/transport/indext.html.twig', [
            'transports' => $transports,
        ]);
    }

    #[Route('/order-by-price', name: 'order_by_prix',methods: ['GET'])]
    public function orderByPrice(TransportRepository $transportRepository): Response
    {
        $transports = $transportRepository->order_By_Prix();

        // Render your template with the sorted list of transports
        return $this->render('front/transport/indext.html.twig', [
            'transports' => $transports,
        ]);
    }

    #[Route('/order-by-type', name: 'order_by_type',methods: ['GET'])]
    public function orderByType(TransportRepository $transportRepository): Response
    {
        $transports = $transportRepository->orderByType();

        // Render your template with the sorted list of transports
        return $this->render('front/transport/indext.html.twig', [
            'transports' => $transports,
        ]);
    }


    #[Route('/{id}', name: 'app_transport_delete', methods: ['POST'])]
    public function delete(Request $request, Transport $transport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($transport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transport_index', [], Response::HTTP_SEE_OTHER);
    }

 
    

}
