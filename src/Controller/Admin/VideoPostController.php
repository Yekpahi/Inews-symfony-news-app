<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use App\Entity\VideoPost;
use App\Form\VideoPostType;
use App\Repository\VideoPostRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
/**
 * @Route("/admin/video-post", name="admin_videoPost_")
 * @package App\Controller\Admin
 */
class VideoPostController extends AbstractController
{
    /**
     * 
     * @Route("/", name="home")
     */
    public function index(VideoPostRepository $videoPostRepo)
    {
        return $this->render('admin/videos/all-videoPost.html.twig', [
            'videoPost' => $videoPostRepo->findAll()
        ]);
    }

    /**
     * @Route("/details/{slug}", name="details")
     */
    public function details($slug, VideoPostRepository $videoPostRepo, Request $request)
    {
        $videoPost = $videoPostRepo->findOneBy(['slug' => $slug]);
        $user = $this->getUser();
        if (!$videoPost) {
            throw new NotFoundHttpException('Pas d\'une trouvé');
        }

        return $this->render('admin/videos/details.html.twig', [
            'videoPost' =>  $videoPost
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/activer/{id}", name="activer")
     */
    public function activer(VideoPost $videoPost)
    {
        $videoPost->setActive(($videoPost->getActive()) ? false : true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($videoPost);
        $em->flush();

        return new Response("true");
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(VideoPost $videoPost)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($videoPost);
        $em->flush();

        $this->addFlash('message', 'Une supprimée avec succès');
        return $this->redirectToRoute('admin_videoPost_home');
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ajout", name="ajout", methods={"GET","POST"})
     */
    public function ajoutvideoPost(Request $request): Response
    {
        $videoPost = new videoPost();
        $form = $this->createForm(VideoPostType::class, $videoPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $videoPost->setUsers($this->getUser());
            $videoPost->setActive(false);
           

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($videoPost);
            $entityManager->flush();

            return $this->redirectToRoute('admin_videoPost_home');
        }
        return $this->render('admin/videos/ajoutvideoPost.html.twig', [
            'videoPost' => $videoPost,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/edit/{id}", name="edit")
     */
    public function editvideoPost(VideoPost $videoPost, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(VideoPostType::class, $videoPost);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var VideoPost   $videoPost */
            $videoPost = $form->getData();
            $em->persist($videoPost);
            $em->flush();
            $this->addFlash('success', 'Une Created! Knowledge is power!');
            return $this->redirectToRoute('admin_videoPost_home', [
                'id' => $videoPost->getId()
            ]);
        }
        return $this->render('admin/videos/ajoutvideoPost.html.twig', [
            'uneform' => $form->createView(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/delete/{id}", name="delete")
     */
    public function deletevideoPost(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $videoPost = $entityManager->getRepository(VideoPost::class)->find($id);
        $entityManager->remove($videoPost);
        $entityManager->flush();

        return $this->redirectToRoute("admin_videoPost_home");
    }
}
