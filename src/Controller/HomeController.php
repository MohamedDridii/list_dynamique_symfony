<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\City;
use App\Form\TicketFormType;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(CityRepository $city_rep,CountryRepository $country_rep ): Response
    {
        //dd($city_rep->findAll(),$country_rep->findAll());
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
    public function createfrom( Request $request,CountryRepository $countryrepo,CityRepository $cityrepo): Response
    {
        $form=$this->createForm(TicketFormType::class,['country'=>$countryrepo->find(1)]);//inserer la pay dans le formulaire
        //evenement apres les données sont inserer dans le formulaire 
       // ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($cityrepo)/*car on utlise cityrepository dans cette fonction*/{
            
           // $country=$event->getData()['country']/*ce ligne doit etres exactement comme le nom dans le formulaire */?? null;
            //
             //$cities=$country=== null ?[]/*si country est null on ne vas pas execute le reste de partie */
             //$cityrepo->findBy(['Country'=>$country],['Name'=>'ASC']);
               // :$cityrepo->FinfByCountryOrderByAscName($country);//this is the function i implemented in the city repository
              
             //$event->getForm()->add('city',EntityType::class,[
               // 'class'=>City::class,
                //'choice_label'=>'name',
                //'choices'=>$cities,
                //'placeholder'=>'please choose a city',
                /*'query_builder'=> function(CityRepository $city)use($country){//une autre facon d'ecrire la meme fonction
                    return $city->createQueryBuilder('c')
                    ->andWhere('c.Country = :Country')//country should be syntaxicaly exactly the same as it is implemented in the entity(each filed should be like that )
                    ->setParameter('Country', $country)
                    ->orderBy('c.Name',"ASC") ;
                },cette partie peut remplacer 'choises'=>cities */
                //'constraints'=> new NotBlank(['message'=>'please choose a city'])
                                 //   ]);
        //})

        //->add('name',TextType::class,[
          //  'constraints'=>new NotBlank(['message'=>'Please enter your name ']),// make the field non empty and add a message if empty
            //'help'=>'this field is necessay '
            //])//la methode add ajoute des champs au formulaire
        //->add('country',EntityType::class,[
          //  'class'=>Country::class,
            //'placeholder'=>'please choose a country',
            //'choice_label'=>'name',//indique le champ dans l'entity country a utilise comme label c'est une option de la classe Entity type 
            //'query_builder'=> fn(CountryRepository $country)=>$country
              //  ->createQueryBuilder('c')
                //->orderBy('c.Name',"ASC"), // fait l'ordre des pays par ordre croisssant en utilisant querybuilder 
            //'constraints'=> new NotBlank(['message'=>'please choose a country'])
        //])
        //->add('message',TextareaType::class,[
          //   'constraints'=> new NotBlank(['message'=>'seems like you have no problems'])
        //])
        //->getForm();//pour recupere le formulaire


        //dd($form->get('city')->getName()); chaque formulaire et composer des champs et ces champ sont aussi des formualeire donc en peut acceder au formlaire fils avec cette methode 
        //dd($form->getConfig());

         $form->handleRequest($request);//recupere les donne dans le formulaire 
          if ($form->isSubmitted()&& $form->isValid()){
       
          }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),//creation de view de formulaire avec html simple ou bien utiliser renderForme et passeer seulement le variable $form sans la methode createView()

        ]);
    }
}
