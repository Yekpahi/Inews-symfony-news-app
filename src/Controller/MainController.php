<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comments;
use App\Entity\VideoPost;
use App\Form\CommentsType;
use App\Form\SearchArticleType;
use App\Repository\LauneRepository;
use App\Repository\ArticlesRepository;
use App\Repository\VideoPostRepository;
use Coduo\PHPHumanizer\NumberHumanizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ArticlesRepository $articlesRepo, LauneRepository $launeRepo, Request $request, VideoPostRepository $videoPostRepo)
    {
        $video = $videoPostRepo->findAll();
        $articles = $articlesRepo->findBy(['active' => true], ['created_at' => 'desc'], 5);
        $laune = $launeRepo->findBy(['active' => true], ['created_at' => 'desc'], 5);
        $article = $articlesRepo->findOneBy([]);
        $une = $launeRepo->findOneBy([]);
        $form = $this->createForm(SearchArticleType::class);
        $search = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On recherche les articles correspondant aux mots clés
            $articles = $articlesRepo->search(
                $search->get('mots')->getData(),
                $search->get('categorie')->getData()
            );
        }
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
            return $this->redirectToRoute('app_home', ['slug' => $article->getSlug()]);
        }

        return $this->render('main/home.html.twig', [
            'commentForm' => $commentForm->createView(),
            'article' => $article,
            'articles' => $articles,
            'laune' => $laune,
            'video' => $video,
            'une' => $une,
            'form' => $form->createView()
            
        ]);
    }

    /**
     * @Route("/videos/details/{slug}", name="video_details")
     */
    public function details($slug, VideoPostRepository $videoPostRepo, $precision = 1)
    {
        $video = $videoPostRepo->findOneBy(['slug' => $slug]);


        if (!$video) {
            throw new NotFoundHttpException('Pas d\'une trouvé');
        }
        $em = $this->getDoctrine()->getManager();
        $nbVue = $video->getNbVue();
        if ($nbVue < 900) {
            // 0 - 900
            $n_format = number_format($nbVue, $precision);
            $suffix = ' ';
        } else if ($nbVue < 900000) {
            // 0.9k-850k
            $n_format = number_format($nbVue / 1000, $precision);
            $suffix = ' K';
        } else if ($nbVue < 900000000) {
            // 0.9m-850m
            $n_format = number_format($nbVue / 1000000, $precision);
            $suffix = ' M';
        } else if ($nbVue < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($nbVue  / 1000000000, $precision);
            $suffix = ' Md';
        } else {
            // 0.9t+
            $n_format = number_format($nbVue / 1000000000000, $precision);
            $suffix = ' T';
        }
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, ' ', $n_format);
        }
        $vuConv = $n_format . $suffix;

        $video->setNbVue($nbVue + 1);
        $em->flush();

        return $this->render('main/videos/details.html.twig', [
            'video' =>  $video,
            'vuConv' => $vuConv
        ]);
    }


    /**
     * @Route("/mentions/legales", name="mentions")
     */
    public function mentions()
    {
        return $this->render('main/mentions.html.twig');
    }
}
