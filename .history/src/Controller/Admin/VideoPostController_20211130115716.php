<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\VideoPost;
use App\Form\VideoPostType;
use App\Repository\VideoPostRepository;
use App\Service\FileUploader;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/videos", name="admin_videoPost_")
 * @package App\Controller\Admin
 */
class VideoPostController extends AbstractController
{
    /**
     * 
     * @Route("/", name="home")
     */
    public function index(VideoPostRepository $videoPostRepo, $id)
    {
        
        $video = $videoPostRepo->findAll(); 
        $entrainement = $videoPostRepo->find($id);
 
        $entrainement->setNbVue($entrainement->getNbVue()+1);      
        return $this->render('admin/videos/all-videoPost.html.twig', [
            'video' =>$video,
            'entrainement' => $entrainement
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
     *@Route("/ajout", name="ajout", methods={"GET","POST"})
     */
    public function ajoutvideoPost(Request $request, FileUploader $fileUploader) : Response
    {
        $video = new VideoPost();
        $form = $this->createForm(VideoPostType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $video->setUsers($this->getUser());
            $video->setActive(false);
            $videoFile = $form->get('video')->getData();
            if ($videoFile) {
                $videoFileName = $fileUploader->upload($videoFile);
                $video->setVideoFilename($videoFileName);
            }
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();
            return $this->redirectToRoute('admin_videoPost_home');
        }
        return $this->render('admin/videos/ajoutvideoPost.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ajout", name="ajout", methods={"GET","POST"})
     */
    /* public function ajoutvideoPost(Request $request): Response
    {
        $video = new VideoPost();
        $form = $this->createForm(VideoPostType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $video->setUsers($this->getUser());
            $video->setActive(false);
            $video = $form->get('file')->getData();

            // On boucle sur les images
            foreach ($video as $vde) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $vde->guessExtension();

                // On copie le fichier dans le dossier uploads
                $vde->move(
                    $this->getParameter('video_directory'),
                    $fichier
                );
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('admin_videoPost_home');
        }
        return $this->render('admin/videos/ajoutvideoPost.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }
*/



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
