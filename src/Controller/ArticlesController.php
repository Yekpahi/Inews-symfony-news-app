<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\User;
use App\Form\CommentsType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use App\Service\SendMailService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles", name="articles_")
 * @package App\Controller
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="liste")
     * @return void 
     */
    public function index(ArticlesRepository $articlesRepo, CategoriesRepository $catRepo, Request $request)
    {
        // On définit le nombre d'éléments par page
        $limit = 10;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("categories");

        // On récupère les annonces de la page en fonction du filtre
        $articles = $articlesRepo->getPaginatedAnnonces($page, $limit, $filters);

        // On récupère le nombre total d'annonces
        $total = $articlesRepo->getTotalAnnonces($filters);

        // On vérifie si on a une requête Ajax
        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('articles/_content.html.twig', compact('articles', 'total', 'limit', 'page'))
            ]);
        }

        // On va chercher toutes les catégories
        $categories = $catRepo->findAll();

        return $this->render('articles/index.html.twig', compact('articles', 'total', 'limit', 'page', 'categories'));
    }

    /**
     * @Route("/details/{slug}", name="details")
     */
    public function details($slug, ArticlesRepository $articlesRepo, Request $request)
    {
        $article = $articlesRepo->findOneBy(['slug' => $slug]);
        $user = $this->getUser();
        if (!$article) {
            throw new NotFoundHttpException('Pas d\'article trouvé');
        }

        // Partie commentaires
        // On crée le commentaire "vierge"
        $comment = new Comments;

        // On génère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);

        $commentForm->handleRequest($request);

        // Traitement du formulaire
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCreatedAt(new DateTime());
            $comment->setArticles($article);
            $comment->setUser($user);
            // On récupère le contenu du champ parentid
            $parentid = $commentForm->get("parentid")->getData();

            // On va chercher le commentaire correspondant
            $em = $this->getDoctrine()->getManager();

            if ($parentid != null) {
                $parent = $em->getRepository(Comments::class)->find($parentid);
            }

            // On définit le parent
            $comment->setParent($parent ?? null);

            $em->persist($comment);
            $em->flush();

            $this->addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('articles_details', ['slug' => $article->getSlug()]);
        }

        return $this->render('articles/details.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView()
        ]);
    }
    /**
     * @Route("/favoris/retrait/{id}", name="retrait_favoris")
     */
    public function retraitFavoris(Articles $article)
    {
        if (!$article) {
            throw new NotFoundHttpException('Pas d\'article trouvée');
        }
        $article->removeFavori($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return $this->redirectToRoute('app_home');
    }
}
