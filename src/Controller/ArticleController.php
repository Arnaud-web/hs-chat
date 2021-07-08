<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleVu;
use App\Entity\LikeArticle;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(['statu'=>true],['publishedAt'=>'desc']);
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'article_index'=>true
        ]);
    }
    #[Route('/my_publications', name: 'my_article_index', methods: ['GET'])]
    public function myIndex(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(['userCreated'=>$this->getUser()->getId()],['id'=>'desc']);
        return $this->render('article/my_index.html.twig', [
            'articles' => $articles,
            'my_article_index'=>true
        ]);
    }

    #[Route('/new', name: 'article_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        $length = 10;

        $randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length);
//        dd($randomletter);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $article->setUserCreated($this->getUser());
            $article->setSlug($randomletter);
            $article->setCreatedAt(new \DateTime());
            if($article->getStatu() == true){
                $article->setPublishedAt(new \DateTime());
            }
            $entityManager->persist($article);
            $entityManager->flush();
            $articleVu = new ArticleVu();
            $articleVu->setArticle($article);
            $entityManager->persist($articleVu);
            $entityManager->flush();
            $articleLike = new LikeArticle();
            $articleLike->setArticle($article);
            $entityManager->persist($articleLike);
            $entityManager->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
            'article_new'=>true
        ]);
    }

    #[Route('/{slug}', name: 'article_show', methods: ['GET'])]
    public function show(Article $article,Request $request): Response
    {
        if($this->getUser()->getId() != $article->getUserCreated()->getId()){
            $articleVu = $article->getArticleVu();
          if(!$articleVu){
              $articleVu = new ArticleVu();
              $articleVu->setArticle($article);
          }

//          dd($articleVu->getUserVu()->contains($this->getUser()));
          if(!$articleVu->getUserVu()->contains($this->getUser())){
              $articleVu->addUserVu($this->getUser());
              $this->getDoctrine()->getManager()->persist($articleVu);
              $this->getDoctrine()->getManager()->flush();
            }


        }

//        dd($request->query->get('like'));
        if($request->query->get('like')){
            $like = $article->getLikeArticle();
            if(!$like){
                $like = new LikeArticle();
                $like->setArticle($article);
            }
            if($like->getUserLike()->contains($this->getUser())){
                $like->getUserLike()->removeElement($this->getUser());
            }else{
                $like->addUserLike($this->getUser());
            }
            $this->getDoctrine()->getManager()->persist($like);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('article_show',['slug'=>$article->getSlug()]);
        }
//        dd($article->getLikeArticle()->getUserLike()[0]->getName());
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{slug}/edit', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($article->getStatu() == true){
                $article->setPublishedAt(new \DateTime());
            }
//            dd($article);
            $this->getDoctrine()->getManager()->persist($article);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }
}
