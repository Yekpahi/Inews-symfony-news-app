<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use App\Entity\ImageALaUne;
use App\Entity\Laune;
use App\Form\CommentsType;
use App\Form\LauneType;
use App\Repository\LauneRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/laune", name="admin_laune_")
 * @package App\Controller\Admin
 */
class LauneController extends AbstractController
{
    /**
     * 
     * @Route("/", name="home")
     */
    public function index(LauneRepository $launeRepo)
    {
        return $this->render('admin/laune/all-une.html.twig', [
            'laune' => $launeRepo->findAll()
        ]);
    }

    /**
     * @Route("/details/{slug}", name="details")
     */
    public function details($slug, LauneRepository $launeRepo, Request $request)
    {
        $laune = $launeRepo->findOneBy(['slug' => $slug]);
        $user = $this->getUser();
        if (!$laune) {
            throw new NotFoundHttpException('Pas d\'une trouvé');
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
            $comment->setLaunes($laune);
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
            return $this->redirectToRoute('admin_laune_details', ['slug' => $laune->getSlug()]);
        }

        return $this->render('admin/laune/details.html.twig', [
            'laune' =>  $laune,
            'commentForm' => $commentForm->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/activer/{id}", name="activer")
     */
    public function activer(Laune $laune)
    {
        $laune->setActive(($laune->getActive()) ? false : true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($laune);
        $em->flush();

        return new Response("true");
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Laune $laune)
    {
        $images =  $laune->getImages();

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
        $em->remove($laune);
        $em->flush();

        $this->addFlash('message', 'Une supprimée avec succès');
        return $this->redirectToRoute('admin_laune_home');
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ajout", name="ajout", methods={"GET","POST"})
     */
    public function ajoutune(Request $request): Response
    {
        $laune = new Laune();
        $form = $this->createForm(LauneType::class, $laune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $laune->setUsers($this->getUser());
            $laune->setActive(false);
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son nom)
                $img = new ImageALaUne();
                $img->setName($fichier);
                $laune->addImage($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($laune);
            $entityManager->flush();

            return $this->redirectToRoute('admin_laune_home');
        }
        return $this->render('admin/laune/ajout-une.html.twig', [
            'laune' => $laune,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/edit/{id}", name="edit")
     */
    public function editune(Laune   $laune, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(LauneType::class, $laune);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Articles   $laune */
            $laune = $form->getData();
            $em->persist($laune);
            $em->flush();
            $this->addFlash('success', 'Une Created! Knowledge is power!');
            return $this->redirectToRoute('admin_laune_home', [
                'id' => $laune->getId()
            ]);
        }
        return $this->render('admin/laune/ajout-une.html.twig', [
            'uneform' => $form->createView(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteune(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $laune = $entityManager->getRepository(Laune::class)->find($id);
        $entityManager->remove($laune);
        $entityManager->flush();

        return $this->redirectToRoute("admin_laune_home");
    }
}
