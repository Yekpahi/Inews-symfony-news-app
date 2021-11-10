<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\User;
use App\Form\CategoriesType;
use App\Form\EditUserType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_REDACTOR")
 * @Route("/admin", name="admin_")
 * @package App\Controller\Admin
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/categories/ajout", name="categories_ajout")
     */
    public function ajoutCategorie(Request $request)
    {
        $categorie = new Categories;

        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_REDACTOR")
     * @Route("/stats", name="stats")
     */
    public function statistiques(CategoriesRepository $categRepo, ArticlesRepository $artRepo)
    {
        // On va chercher toutes les catégories
        $categories = $categRepo->findAll();

        $categNom = [];
        $categColor = [];
        $categCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach ($categories as $categorie) {
            $categNom[] = $categorie->getName();
            $categColor[] = $categorie->getColor();
            $categCount[] = count($categorie->getArticles());
        }

        // On va chercher le nombre d'articles publiées par date
        $articles = $artRepo->countByDate();

        $dates = [];
        $articlesCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach ($articles as $article) {
            $dates[] = $article['dateArticles'];
            $articlesCount[] = $article['count'];
        }

        return $this->render('admin/stats.html.twig', [
            'categNom' => json_encode($categNom),
            'categColor' => json_encode($categColor),
            'categCount' => json_encode($categCount),
            'dates' => json_encode($dates),
            'articlesCount' => json_encode($articlesCount),
        ]);
    }

    /**
     * @IsGranted("ROLE_REDACTOR")
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function usersList(UserRepository $users)
    {
        return $this->render('admin/users/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
      
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        
            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/users/editUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

      /**
       * @Route("/utilisateurs/supprimer/{id}", name="supprimer_utilisateur")
     * 
     */
    public function deleteuser(int $id, User $user): Response
    {

        $currentUserId = $this->getUser()->getId();
        if ($currentUserId == $id)
        {
          $session = $this->get('session');
          $session = new Session();
          $session->invalidate();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
    
        
        // Ceci ne fonctionne pas avec la création d'une nouvelle session !
        $this->addFlash('success', 'Votre compte utilisateur a bien été supprimé !'); 
        
        return $this->redirectToRoute('admin_home');
    }
}
