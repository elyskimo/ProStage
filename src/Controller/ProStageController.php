<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
//use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use App\Form\EntrepriseType;
use App\Form\StageType;
use App\Form\FormationType;


class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
     */
    public function index()
    {
        $repoStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repoStage->findByEntreprise();
        return $this->render('pro_stage/index.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/entreprise/", name="pro_stage_entreprise")
     */
    public function afficherPageEntreprise()
    {
      $repoEntreprise= $this->getDoctrine()->getRepository(Entreprise::class);
      $entreprises= $repoEntreprise->findAll();
      return $this->render('pro_stage/entreprises.html.twig',['entreprises'=>$entreprises]);
    }

    /**
     * @Route("/formations/", name="pro_stage_formation")
     */
    public function afficherPageFormation()
    {
      $repoFormation= $this->getDoctrine()->getRepository(Formation::class);
      $formations= $repoFormation->findAll();
      return $this->render('pro_stage/formations.html.twig',['formations'=>$formations]);
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_stages")
     */
    public function afficherPageStage($id)
    {
      $repoStage = $this->getDoctrine()->getRepository(Stage::class);
      $stage = $repoStage->find($id);

      return $this->render('pro_stage/stages.html.twig',['stage'=>$stage]);
    }

    /**
     * @Route("/stages/entreprise/{nom}", name="pro_stage_stagesParEntreprise")
     */
    public function afficherPageStagesEntreprise($nom)
    {
      $repoStage = $this->getDoctrine()->getRepository(Stage::class);
      $stages = $repoStage->findByNomEntreprise($nom);

    return $this->render('pro_stage/index.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/stages/formation/{nom}", name="pro_stage_stagesParFormation")
     */
    public function afficherPageStagesFormation($nom)
    {
      $repoStage = $this->getDoctrine()->getRepository(Stage::class);
      $stages = $repoStage->findByNomFormation($nom);

    return $this->render('pro_stage/index.html.twig',['stages'=>$stages]);
    }
    /**
     * @Route("/entreprise/ajout", name="pro_stage_ajoutEntreprise")
     */
    public function ajoutEntreprise(Request $request, ObjectManager $manager)
    {
        $entreprise = new Entreprise();
        // création du formulaire
        $formulaire = $this->createForm(EntrepriseType::class, $entreprise);

        // on demande au formulaire d'analyser la derniere requete http
        $formulaire->handleRequest($request);

        //dump($entreprise);

         if ($formulaire->isSubmitted() && $formulaire->isValid())
         {
           //enregistrer les données en base de données
           $manager->persist($entreprise);
           $manager->flush();
           //rediriger l'utilisateur vers la page d'accueil
           return $this->redirectToRoute('pro_stage_entreprise');
         }

        // création de la représentation graphique du fomrulaire
        $vueFormulaire = $formulaire->createView();

        return $this->render('pro_stage/ajoutEntreprise.html.twig',
                            ['vueFormulaire' => $vueFormulaire,
                            'action'=>"ajouter"]);
    }

    /**
     * @Route("/entreprise/modification/{id}", name="pro_stage_modifEntreprise")
     */
    public function modifierEntreprise(Request $request, ObjectManager $manager, Entreprise $entreprise)
    {
        // création du formulaire
        $formulaire = $this->createForm(EntrepriseType::class, $entreprise);

        // on demande au formulaire d'analyser la derniere requete http
        $formulaire->handleRequest($request);
        //dump($entreprise);

         if ($formulaire->isSubmitted())
         {
           //enregistrer les données en base de données
           $manager->persist($entreprise);
           $manager->flush();
           //rediriger l'utilisateur vers la page d'accueil
           return $this->redirectToRoute('pro_stage_entreprise');
         }

        // création de la représentation graphique du fomrulaire
        $vueFormulaire = $formulaire->createView();

        return $this->render('pro_stage/ajoutEntreprise.html.twig',
                            ['vueFormulaire' => $vueFormulaire,
                            'action'=>"modifier"]);
    }

    /**
     * @Route("/stage/ajout", name="pro_stage_ajoutStage")
     */
    public function ajoutStage(Request $request, ObjectManager $manager)
    {
        $stage = new Stage();
        // création du formulaire
        $formulaire = $this->createForm(StageType::class, $stage);

        // on demande au formulaire d'analyser la derniere requete http
        $formulaire->handleRequest($request);

        //dump($entreprise);

         if ($formulaire->isSubmitted() && $formulaire->isValid())
         {
           //enregistrer les données en base de données
           $manager->persist($stage);
           $manager->flush();
           //rediriger l'utilisateur vers la page d'accueil
           return $this->redirectToRoute('pro_stage');
         }

        // création de la représentation graphique du fomrulaire
        $vueFormulaire = $formulaire->createView();

        return $this->render('pro_stage/ajoutStage.html.twig',
                            ['vueFormulaire' => $vueFormulaire,
                            'action'=>"ajouter"]);
    }
    /**
     * @Route("/formation/ajout", name="pro_stage_ajoutFormation")
     */
    public function ajoutFormation(Request $request, ObjectManager $manager)
    {
        $formation = new Formation();
        // création du formulaire
        $formulaire = $this->createForm(FormationType::class, $formation);

        // on demande au formulaire d'analyser la derniere requete http
        $formulaire->handleRequest($request);

        //dump($entreprise);

         if ($formulaire->isSubmitted() && $formulaire->isValid())
         {
           //enregistrer les données en base de données
           $manager->persist($formation);
           $manager->flush();
           //rediriger l'utilisateur vers la page d'accueil
           return $this->redirectToRoute('pro_stage_formation');
         }

        // création de la représentation graphique du fomrulaire
        $vueFormulaire = $formulaire->createView();

        return $this->render('pro_stage/ajoutFormation.html.twig',
                            ['vueFormulaire' => $vueFormulaire,
                            'action'=>"ajouter"]);
    }



    ///**
     //* @Route("/stages/entreprise/{id}", name="pro_stage_stagesParEntreprise")
     //*/
    //public function afficherPageStage($id)
    //{
      //$entreprise= $this->getDoctrine()->getRepository(Entreprise::class)->findOneBy(["id" => $id])

      //$stages = $this->getDoctrine()->getRepository(Stage::class)->findBy(["entreprises"=>$id]);
      //$stage = $repoStage->findBy([])

      //return $this->render('pro_stage/stages.html.twig',['idStage'=>$id,"entreprise");
    //}



}
