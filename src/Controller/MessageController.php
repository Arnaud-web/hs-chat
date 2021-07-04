<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\MessageVu;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/message')]
class MessageController extends AbstractController
{
    #[Route('/', name: 'message_index', methods: ['GET'])]
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }
    #[Route('/all', name: 'messages_index', methods: ['GET'])]

    public function listAction( PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $appointmentsRepository = $em->getRepository(Message::class);
        // Find all the data on the Appointments table, filter your query as you need
        $allAppointmentsQuery = $appointmentsRepository->createQueryBuilder('p')
//            ->where('p.status != :status')
//            ->setParameter('status', 'canceled')
            ->getQuery();
        $appointments = $paginator->paginate(
        // Doctrine Query, not results
            $allAppointmentsQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );

        $pagination = $appointments;

        // parameters to template
        return $this->render('message/list.html.twig', ['pagination' => $pagination]);
    }

    #[Route('/{name}', name: 'message_new', methods: ['GET', 'POST'])]
    public function new(PaginatorInterface $paginator,Request $request,User $user): Response
    {
//        dd($user);
//        dd($this->getUser()->getMessagesSend());
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        $idm = $this->getUser()->getId().$user->getId();
        $idm1 = $user->getId().$this->getUser()->getId();
        $messages =$this->getDoctrine()->getRepository(Message::class)->findMessages(['idm'=>$idm,'idm1'=>$idm1]);
        $messages = array_reverse($messages);
        foreach ($messages as $m){
            $mVu = $this->getDoctrine()->getRepository(MessageVu::class)->findBy(['message'=>$m,'user'=>$this->getUser()]);
            if (!$mVu){
                $vu = new MessageVu();
                $vu->setMessage($m);
                $vu->setUser($this->getUser());
                $vu->setVuAt(new \DateTime());
//                dd($vu);
                $this->getDoctrine()->getManager()->persist($vu);
                $this->getDoctrine()->getManager()->flush();
                $m->setNew(true);
                $this->getDoctrine()->getManager()->persist($m);
                $this->getDoctrine()->getManager()->flush();
            }
        }
//        $messagesR =$this->getDoctrine()->getRepository(Message::class)->findBy(['userReceved'=>$user]);

//    dd($messages);
        $nombre = count($messages)/4;
        if($nombre<1){
            $nombre = 1;
//            $max =
        }
//        dd(round($nombre));
        if($nombre>round($nombre)){
        $nombre = 1+1;
//            $max =
        }
        $nombre = round($nombre);
//        dd($nombre);
        $messagesp = $paginator->paginate(
        // Doctrine Query, not results
            $messages,
            // Define the page parameter
            $request->query->getInt('page', $nombre),
//           dd( $request->query->getInt('page',2)),
            // Items per page
            4
        );
        $messages = $messagesp;

        if ($form->isSubmitted() && $form->isValid()) {
//            dd('ok');
            $entityManager = $this->getDoctrine()->getManager();
            $message->setUserSend($this->getUser());
            $message->setUserReceved($user);
            $message->setIdm($idm);
            $message->setSendAt(new \DateTime());
            $entityManager->persist($message);
            $entityManager->flush();

//                dd($vu);
            $vu = new MessageVu();
            $vu->setMessage($message);
            $vu->setUser($this->getUser());
            $vu->setVuAt(new \DateTime());
            $this->getDoctrine()->getManager()->persist($vu);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_new',['name'=>$user->getName()]);
        }

        return $this->render('message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
            'messages'=>$messages,
        ]);
    }

    #[Route('/mes/{id}', name: 'message_show', methods: ['GET'])]
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/{id}/edit', name: 'message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Message $message): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_index');
    }
}
