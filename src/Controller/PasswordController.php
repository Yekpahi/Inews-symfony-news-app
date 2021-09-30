<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ChangePassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use App\Form\ChangePasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordController extends AbstractController
{
    /**
     * @Route("/user/pass/modifier", name="modifier_mot_de_passe")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $changePassword = new ChangePassword();
        // rattachement du formulaire avec la class changePassword
        $form = $this->createForm('App\Form\ChangePasswordType', $changePassword);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $newpwd = $form->get('Password')['first']->getData();

            $newEncodedPassword = $passwordEncoder->encodePassword($user, $newpwd);
            $user->setPassword($newEncodedPassword);

            $em->flush();
            $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

            return $this->redirectToRoute('user');
        }

        return $this->render('password/index.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}
