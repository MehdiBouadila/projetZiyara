<?php

namespace App\Controller;

use App\Entity\Pack;
use App\Form\Pack1Type;
use App\Repository\PackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/pack')]
class PackController extends AbstractController
{
    #[Route('/', name: 'app_pack_index', methods: ['GET'])]
    public function index(PackRepository $packRepository): Response
    {
        return $this->render('pack/index.html.twig', [
            'packs' => $packRepository->findAll(),
        ]);
    }

    #[Route('/front', name: 'app_packfront_index', methods: ['GET'])]
    public function indexfront(PackRepository $packRepository): Response
    {
        return $this->render('pack/indexFront.html.twig', [
            'packs' => $packRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_pack_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $pack = new Pack();
        $form = $this->createForm(Pack1Type::class, $pack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if the guide is already used by another pack
            $existingGuide = $entityManager->getRepository(Pack::class)->findOneBy(['guide' => $pack->getGuide()]);
            // Check if the transporter is already used by another pack
            $existingTransport = $entityManager->getRepository(Pack::class)->findOneBy(['transports' => $pack->getTransports()]);

            if ($existingGuide) {
                $this->addFlash('danger', 'Guide is already used by another pack.');
            }

            if ($existingTransport) {
                $this->addFlash('danger', 'Transporter is already used by another pack.');
            }

            if (!$existingGuide && !$existingTransport) {
                /** @var UploadedFile $imageFile */
                $imageFile = $form->get('imagePack')->getData();

                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                    // Move the file to the directory where your images are stored
                    try {
                        $imageFile->move(
                            $this->getParameter('img_directory'), // specify the directory where images should be stored
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // Handle the exception if something happens during the file upload
                    }

                    // Update the 'image' property to store the file name instead of its contents
                    $pack->setImagePack($newFilename);
                }

                $entityManager->persist($pack);
                $entityManager->flush();

                $this->addFlash('success', 'Pack' . $pack->getTitrePack() . ' created successfully!');

                return $this->redirectToRoute('app_pack_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('pack/new.html.twig', [
            'pack' => $pack,
            'form' => $form,
        ]);
    }

    // #[Route('/new', name: 'app_pack_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    // {
    //     $pack = new Pack();
    //     $form = $this->createForm(Pack1Type::class, $pack);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         /** @var UploadedFile $imageFile */
    //         $imageFile = $form->get('imagePack')->getData();

    //         if ($imageFile) {
    //             $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
    //             $safeFilename = $slugger->slug($originalFilename);
    //             $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

    //             // Move the file to the directory where your images are stored
    //             try {
    //                 $imageFile->move(
    //                     $this->getParameter('img_directory'), // specify the directory where images should be stored
    //                     $newFilename
    //                 );
    //             } catch (FileException $e) {
    //                 // Handle the exception if something happens during the file upload
    //             }

    //             // Update the 'image' property to store the file name instead of its contents
    //             $pack->setImagePack($newFilename);
    //         }

    //         $entityManager->persist($pack);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_pack_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('pack/new.html.twig', [
    //         'pack' => $pack,
    //         'form' => $form,
    //     ]);
    // }


    #[Route('/{id}', name: 'app_pack_show', methods: ['GET'])]
    public function show(Pack $pack): Response
    {
        return $this->render('pack/show.html.twig', [
            'pack' => $pack,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pack_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pack $pack, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Pack1Type::class, $pack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pack/edit.html.twig', [
            'pack' => $pack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pack_delete', methods: ['POST'])]
    public function delete(Request $request, Pack $pack, EntityManagerInterface $entityManager): Response
    {
        $reservations = $pack->getReservations();

        // Check if there are any reservations associated with the pack
        if ($reservations->isEmpty()) {
            if ($this->isCsrfTokenValid('delete' . $pack->getId(), $request->request->get('_token'))) {
                $entityManager->remove($pack);
                $entityManager->flush();
            }
            $this->addFlash('success', 'The pack' . $pack->getTitrePack() . ' successfully Deleted! ');

            return $this->redirectToRoute('app_pack_index', [], Response::HTTP_SEE_OTHER);
        } else {
            // If there are reservations associated with the pack, handle accordingly
            $this->addFlash('danger', 'the pack' . $pack->getTitrePack() . ' is already reserved ');
            return $this->redirectToRoute('app_pack_index');
        }
    }
}
