<?php

namespace App\Controller;

use App\Entity\Style;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
//        dd($request);
        if($request->query->get('navcolor')){
            $style = $this->getDoctrine()->getRepository(Style::class)->findOneBy(['userStyle'=>$this->getUser()]);
//            dd($test);
            if($style == null){
                $style = new Style();
                $style->setUserStyle($this->getUser());
            }
            $style->setNavColor($request->query->get('navcolor'));
            $this->getDoctrine()->getManager()->persist($style);
            $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('home');

        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'home'=>true
        ]);
    }
}
