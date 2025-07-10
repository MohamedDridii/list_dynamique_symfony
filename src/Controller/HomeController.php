<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
