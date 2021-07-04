<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserPhoto;
use App\Form\UserPhotoType;
use App\Repository\UserPhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user-photo')]
class UserPhotoController extends AbstractController
{
    #[Route('/', name: 'user_photo_index', methods: ['GET'])]
    public function index(UserPhotoRepository $userPhotoRepository): Response
    {
        return $this->render('user_photo/index.html.twig', [
            'user_photos' => $userPhotoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'user_photo_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $userPhoto = new UserPhoto();
        $form = $this->createForm(UserPhotoType::class, $userPhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $userPhoto->setUser($this->getUser());
            $entityManager->persist($userPhoto);
            $entityManager->flush();
            $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($this->getUser()->getId());
            $user->setPhoto($userPhoto->getImage());
            $entityManager->persist($user);
            $entityManager->flush();
//            dd($user);
            return $this->redirectToRoute('user_show',['name'=>$this->getUser()->getName()]);
        }

        return $this->render('user_photo/new.html.twig', [
            'user_photo' => $userPhoto,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'user_photo_show', methods: ['GET'])]
    public function show(UserPhoto $userPhoto): Response
    {
        return $this->render('user_photo/show.html.twig', [
            'user_photo' => $userPhoto,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_photo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserPhoto $userPhoto): Response
    {
        $form = $this->createForm(UserPhotoType::class, $userPhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_photo_index');
        }

        return $this->render('user_photo/edit.html.twig', [
            'user_photo' => $userPhoto,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'user_photo_delete', methods: ['POST'])]
    public function delete(Request $request, UserPhoto $userPhoto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userPhoto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userPhoto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_photo_index');
    }
}
