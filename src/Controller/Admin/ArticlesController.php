<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/articles", name="admin_articles_")
 * @package App\Controller\Admin
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticlesRepository $articlesRepo)
    {
        return $this->render('admin/articles/all-articles.html.twig', [
            'articles' => $articlesRepo->findAll()
        ]);
    }

    /**
     * @Route("/activer/{id}", name="activer")
     */
    public function activer(Articles $article)
    {
        $article->setActive(($article->getActive()) ? false : true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new Response("true");
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Articles $article)
    {
        $images = $article->getImages();

        if ($images) {
            // On boucle sur les images de l'annonce
            foreach ($images as $image) {
                // On "génère" le chemin physique de l'image
                $nomImage = $this->getParameter("images_directory") . '/' . $image->getName();

                // On vérifie si l'image existe
                if (file_exists($nomImage)) {
                    unlink($nomImage);
                }
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        $this->addFlash('message', 'Article supprimée avec succès');
        return $this->redirectToRoute('admin_articles_home');
    }
}
