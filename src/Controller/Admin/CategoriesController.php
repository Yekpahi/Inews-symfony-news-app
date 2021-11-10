<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categories", name="admin_categories_")
 * @package App\Controller\Admin
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(CategoriesRepository $catsRepo)
    {
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $catsRepo->findAll()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ajout", name="ajout")
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

            return $this->redirectToRoute('admin_categories_home');
        }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/modifier/{id}", name="modifier")
     */
    public function ModifCategorie(Categories $categorie, Request $request)
    {
        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('admin_categories_home');
        }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/delete/{id}", name="delete", requirements={"id" = "\d+"})
     */
    public function delete(Request $request, Categories $entity)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_categories_delete', ['id' => $entity->getId()])) // action=""
            ->setMethod('DELETE')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            // Crée un message de confirmation
            $t = $this->get('translator');
            $this->addFlash('success', $t->trans('category.delete.success'));

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/categories/index.html.twig', array(
            'form' => $form->createView(), // Envoi le formulaire à la vue
            'entity' => $entity,
        ));
    }





    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/delete/{id}", name="delete")
     */
    public function deletecategorie(Request $request, Categories $categorie): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute("admin_categories_home");
    }
}
