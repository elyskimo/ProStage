<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {

    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function inscription(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        // création du formulaire
        $formulaire = $this->createForm(UserType::class, $user);

        // on demande au formulaire d'analyser la derniere requete http
        $formulaire->handleRequest($request);

        //dump($entreprise);

         if ($formulaire->isSubmitted() && $formulaire->isValid())
         {
           // attribuer un role a l'utilisateur
           $user->setRoles(['ROLE_USER']);

           // encoder le mot de passe
           $mdpEncode = $encoder->encodePassword($user, $user->getPassword());
           $user->setPassword($mdpEncode);

           //enregistrer les données en base de données
           $manager->persist($user);
           $manager->flush();
           //rediriger l'utilisateur vers la page d'accueil
           return $this->redirectToRoute('app_login');
         }

        // création de la représentation graphique du fomrulaire
        $vueFormulaire = $formulaire->createView();

        return $this->render('security/inscription.html.twig',
                            ['vueFormulaire' => $vueFormulaire]);
    }
}
