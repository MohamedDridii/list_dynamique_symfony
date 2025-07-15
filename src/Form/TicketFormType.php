<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Country;
use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use Symfony\Component\Validator\Constraints\NotBlank;

class TicketFormType extends AbstractType
{   
    public function __construct(private CityRepository $cityrepo){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) /*car on utlise cityrepository dans cette fonction*/{
            
            $country=$event->getData()['country']/*ce ligne doit etres exactement comme le nom dans le formulaire */?? null;
            //
             $cities=$country=== null ?[]/*si country est null on ne vas pas execute le reste de partie */
             //$cityrepo->findBy(['Country'=>$country],['Name'=>'ASC']);
                :$this->cityrepo->FinfByCountryOrderByAscName($country);//this is the function i implemented in the city repository
              
             $event->getForm()->add('city',EntityType::class,[
                'class'=>City::class,
                'choice_label'=>'name',
                'choices'=>$cities,
                'placeholder'=>'please choose a city',
                /*'query_builder'=> function(CityRepository $city)use($country){//une autre facon d'ecrire la meme fonction
                    return $city->createQueryBuilder('c')
                    ->andWhere('c.Country = :Country')//country should be syntaxicaly exactly the same as it is implemented in the entity(each filed should be like that )
                    ->setParameter('Country', $country)
                    ->orderBy('c.Name',"ASC") ;
                },cette partie peut remplacer 'choises'=>cities */
                'constraints'=> new NotBlank(['message'=>'please choose a city'])
                                    ]);
        })
           ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) /*car on utlise cityrepository dans cette fonction*/{
                dd($event->getData());
            
        })


        ->add('name',TextType::class,[
            'constraints'=>new NotBlank(['message'=>'Please enter your name ']),// make the field non empty and add a message if empty
            'help'=>'this field is necessay '
            ])//la methode add ajoute des champs au formulaire
        ->add('country',EntityType::class,[
            'class'=>Country::class,
            'placeholder'=>'please choose a country',
            'choice_label'=>'name',//indique le champ dans l'entity country a utilise comme label c'est une option de la classe Entity type 
            'query_builder'=> fn(CountryRepository $country)
                => $country
                ->createQueryBuilder('c')
                ->orderBy('c.Name',"ASC"), // fait l'ordre des pays par ordre croisssant en utilisant querybuilder 
            'constraints'=> new NotBlank(['message'=>'please choose a country'])
        ])
        ->add('message',TextareaType::class,[
             'constraints'=> new NotBlank(['message'=>'seems like you have no problems'])
        ])
        ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
