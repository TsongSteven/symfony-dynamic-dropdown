<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Region;
use App\Entity\Category;
use App\Entity\Population;
use App\Entity\SubCategory;
use App\Entity\Property;
use App\Entity\Mc;
use App\Entity\MonthlyConsumption;
use App\Form\McType;
use App\Form\McsType;
use App\Form\MonthlyConsumptionType;
use App\Form\CategoryType;
use App\Form\LocationType;
use App\Form\SubCategoryType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(EntityManagerInterface $em): Response
    {
        $regions = $em->getRepository(Region::class)->findAll();
        $populations = $em->getRepository(Population::class)->findAll();
        return $this->render('chart/index.html.twig', [
            'regions' => $regions,
            'populations' => $populations,
        ]);
    }

    #[Route('/add-category', name:'add-category')]
    public function addCategory(Request $request, EntityManagerInterface $em)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            $this->addFlash('message', 'Category - '.$category->getName().' Added!!');

            return $this->redirectToRoute('add-items');
        }
        return $this->render('admin/add_category.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/add-items', name:'add-items')]
    public function addSubCategory(Request $request, EntityManagerInterface $em)
    {
        $subCategory = new SubCategory();
        $category = new Category();
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $subCategory->setCategory($subCategory->getCategory());
            $em->persist($subCategory);
            $em->flush();

            $this->addFlash('message', 'Item - '.$subCategory->getName().' Added!!');

            return $this->redirectToRoute('add-items');
        }
        return $this->render('admin/add_sub_category.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/add-mc', name: 'mc', methods: ['GET', 'POST'])]
    public function addMc(Request $request, EntityManagerInterface $em)
    {
        $monthlyConsumption = new MonthlyConsumption();
        $form = $this->createForm(MonthlyConsumptionType::class, $monthlyConsumption);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($monthlyConsumption->getWeight() != null) {
                $monthlyConsumption->setCategory($monthlyConsumption->getCategory());
                $monthlyConsumption->setSubCategory($monthlyConsumption->getSubCategory());
                $monthlyConsumption->setLocation($monthlyConsumption->getLocation());
                $monthlyConsumption->setProperty($monthlyConsumption->getProperty());

                $em->persist($monthlyConsumption);
                $em->flush();
            }
        }
        return $this->render('admin/add_mc.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // #[Route('/item-lists', name: 'item-lists')]
    public function itemLists(EntityManagerInterface $em)
    {
        $lists = $em->getRepository(Category::class)->findAll();
        
        return $this->render('admin/item-lists.html.twig', [
            'lists' => $lists
        ]);
    }

    #[Route('/mc-lists', name: 'mc-lists')]
    public function mcItemLists(EntityManagerInterface $em)
    {
        $lists = $em->getRepository(MonthlyConsumption::class)->findAll();

        return $this->render('admin/lists_mc.html.twig', [
            'lists' => $lists
        ]);
    }

    #[Route('/add-mcs', name: 'mcs', methods:['GET','POST'])]
    public function addMcs(Request $request, EntityManagerInterface $em)
    {
        $location = [];
        $region = [];
        $form = $this->createForm(McsType::class, null);
        $form->handleRequest($request);
        $category = $em->getRepository(Category::class)->findAll();
        if($form->isSubmitted() && $form->isValid()) {
            if($form->getData()['mcs']) {

                $populationCount = new Population();
                $location = $form->getData()['location'];
                $region = $form->getData()['region'];
                $populationCount->setFamilyCount($form->getData()['family_count']);
                $populationCount->setPgCount($form->getData()['pg_count']);
                $populationCount->setHostelCount($form->getData()['hostel_count']);
                $populationCount->setHotelCount($form->getData()['hotel_count']);
                $populationCount->setRestaurantCount($form->getData()['restaurant_count']);
                $populationCount->setLocation($form->getData()['location']);
                $populationCount->setRegion($form->getData()['region']);
                $em->persist($populationCount);

                foreach($form->getData()['mcs'] as $mc) {
                    $monthlyConsumption = new Mc();
                    $monthlyConsumption->setFamily($mc['family']);
                    $monthlyConsumption->setPg($mc['pg']);
                    $monthlyConsumption->setHostel($mc['hostel']);
                    $monthlyConsumption->setHotel($mc['hotel']);
                    $monthlyConsumption->setRestaurant($mc['restaurant']);
                    $monthlyConsumption->setCategory($mc['category']);
                    $monthlyConsumption->setUnit($mc['unit']);
                    $monthlyConsumption->setLocation($location);
                    $monthlyConsumption->setRegion($region);
                    $em->persist($monthlyConsumption);
                }

                $em->flush();
                $this->addFlash('message', 'Item(s) Added!');

                return $this->redirectToRoute('mcs');
            }
        }
        return $this->render('admin/add_mcs.html.twig', [
            'form' => $form->createView(),
            'category' => count($category)
        ]);
    }


    #[Route('/edit-mcs/{locationId}/{regionId}', name: 'edit-mcs', methods:['GET','POST'])]
    public function editMcs(Request $request, EntityManagerInterface $em, $locationId, $regionId)
    {
        $location = $em->getRepository(Location::class)->find($locationId);
        $population = $em->getRepository(Population::class)->find($locationId);
        $region = $em->getRepository(Region::class)->find($regionId);
        $mcs = $em->getRepository(Mc::class)->find($locationId);
        $form = $this->createForm(McsType::class,null);
        $monthlyConsumption = new ArrayCollection();
        foreach($location->getMcs() as $mc)
        {
            $monthlyConsumption->add($mc);
        }

        $form->get('mcs')->setData($monthlyConsumption);
        $form->get('region')->setData($region);
        $form->get('family_count')->setData($population->getFamilyCount());
        $form->get('pg_count')->setData($population->getPgCount());
        $form->get('hotel_count')->setData($population->getHotelCount());
        $form->get('hostel_count')->setData($population->getHostelCount());
        $form->get('restaurant_count')->setData($population->getRestaurantCount());
        $form->handleRequest($request);
        $category = $em->getRepository(Category::class)->findAll();
        if($form->isSubmitted() && $form->isValid()) {
            if($form->getData()['mcs']) {

                $populationCount = new Population();
    
                $populationCount->setFamilyCount($form->getData()['family_count']);
                $populationCount->setPgCount($form->getData()['pg_count']);
                $populationCount->setHostelCount($form->getData()['hostel_count']);
                $populationCount->setHotelCount($form->getData()['hotel_count']);
                $populationCount->setRestaurantCount($form->getData()['restaurant_count']);
                $populationCount->setLocation($form->getData()['location']);
                $populationCount->setRegion($form->getData()['region']);
                $em->persist($populationCount);

                foreach($form->getData()['mcs'] as $mc) {
                    $monthlyConsumption = new Mc();
                    $monthlyConsumption->setFamily($mc['family']);
                    $monthlyConsumption->setPg($mc['pg']);
                    $monthlyConsumption->setHostel($mc['hostel']);
                    $monthlyConsumption->setHotel($mc['hotel']);
                    $monthlyConsumption->setRestaurant($mc['restaurant']);
                    $monthlyConsumption->setCategory($mc['category']);
                    $monthlyConsumption->setUnit($mc['unit']);
                    $monthlyConsumption->setLocation($form->getData()['location']);
                    $monthlyConsumption->setRegion($form->getData()['region']);
                    $em->persist($monthlyConsumption);
                }

                $em->flush();
                $this->addFlash('message', 'Item(s) Updated!');

                return $this->redirectToRoute('mcs');
            }
        }
        return $this->render('admin/add_mcs.html.twig', [
            'form' => $form->createView(),
            'category' => count($category)
        ]);
    }



    #[Route('/test', name: 'test')]
    public function test(Request $request, EntityManagerInterface $em)
    {
        $location = new Location();

        $form = $this->createForm(LocationType::class, null);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());

        }
        return $this->render('admin/test.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/location-based-data/{id}', name: 'location-based-data')]
    public function locationBasedData(Request $request, EntityManagerInterface $em, $id)
    {
        $location = new Location();
        $lists =  $em->getRepository(Location::class)->find($id);
        $population =  $em->getRepository(Population::class)->find($id);
        return $this->render('chart/location-based-data.html.twig', [
            'lists' => $lists,
            'population' => $population
        ]);
    }
}
