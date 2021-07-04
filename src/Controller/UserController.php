<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findBy([],['name'=>'asc']),
            'titre' =>''
        ]);
    }
    #[Route('/suivies', name: 'suivie_index', methods: ['GET'])]
    public function suivies(UserRepository $userRepository): Response
    {
        $users= $this->getUser()->getFrinds();
//        dd($this->getUser()->getMessagesSend());

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'titre' => 'suivies',
        ]);
    }
    #[Route('/all_messages', name: 'all_message_index', methods: ['GET'])]
    public function allMessage(UserRepository $userRepository): Response
    {
        $users= $this->getUser()->getFrinds();


        return $this->render('user/index_all_message.html.twig', [
            'users' => $users,
            'titre' => 'All Messages',
        ]);
    }
    #[Route('/abonnees', name: 'abonnee_index', methods: ['GET'])]
    public function abonnee(UserRepository $userRepository): Response
    {
        $users= $this->getUser()->getMyFrind();
//        dd($users);
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'titre' => 'Abonnees',
        ]);
    }
    #[Route('/-{name}/', name: 'frind_new', methods: ['GET'])]
    public function newFrind (UserRepository $userRepository,User $user=null): Response
    {
//        dd($user);
        $me = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
//        dd($me);
        $me->addFrind($user);
//        dd($me);
        $this->getDoctrine()->getManager()->persist($me);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('user_index');
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $user->getPassword()==$user->getConfirmPassword()) {
            $isExiste = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$user->getEmail()]);
            if (!isset( $isExiste)){
            $entityManager = $this->getDoctrine()->getManager();
            $user->setCreatedAt(new \DateTime());
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($encoder->encodePassword($user,$user->getPassword()));
//            dd($user);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
            }
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{name}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user,UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isPassword = $encoder->isPasswordValid($user,$user->getConfirmPassword());
            if ($isPassword){
//                dd($isPassword);
                $user->setUpdatedAt(new \DateTime());
                $isExiste = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$user->getEmail()]);
                if(isset($isExiste)){
                    if (($isExiste->getId() == $this->getUser()->getId())){
                        $this->getDoctrine()->getManager()->flush();

                        return $this->redirectToRoute('user_index');
                    }
                }else{
                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('user_index');
                }
            }

        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
