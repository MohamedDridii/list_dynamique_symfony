<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(CityRepository $city_rep,CountryRepository $country_rep ): Response
    {
        dd($city_rep->findAll(),$country_rep->findAll());
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    // or we can use manage registry to replace injecting each repository seperatly
    /*#[Route('/home', name: 'app_home')]
    public function index1(ManagerRegistry $doctrine ): Response
    {
        $city_rep=$doctrine->getRepository(CityRepository::class);
        $country_rep=$doctrine->getRepository(CountryRepository::class);
        dd($city_rep->findAll(),$country_rep->findAll());
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }*/
     #[Route('/form', name: 'app_form')]
    public function createfrom( ): Response
    {
        $form=$this->createFormBuilder()
        ->add('name',TextType::class)//la methode add ajoute des champs au formulaire
        ->add('country',EntityType::class,[
            'class'=>Country::class,
            'placeholder'=>'please choose a country',
            'choice_label'=>'name',//indique le champ dans l'entity country a utilise comme label c'est une option de la classe Entity type 
            'query_builder'=> fn(CountryRepository $country)=>$country->createQueryBuilder('c')->orderBy('c.Name',"ASC") // fait l'ordre des pays par ordre croisssant en utilisant querybuilder 
        ])
        ->add('city',EntityType::class,[
            'class'=>City::class,
            'choice_label'=>'name',
            'placeholder'=>'please choose a city',
            'query_builder'=> function(CityRepository $city){//une autre facon d'ecrire la meme fonction
                return $city->createQueryBuilder('c')->orderBy('c.Name',"ASC") ;
            }
        ])
        ->add('message',TextareaType::class)
        ->getForm();//pour reupere le formulaire
        // dd($form->createView());
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),//creation de view de formulaire avec html simple ou bien utiliser renderForme et passeer seulement le variable $form sans la methode createView()

        ]);
    }
}
