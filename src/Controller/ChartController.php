<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Category;
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
        $locations = $em->getRepository(Location::class)->findAll();
        return $this->render('chart/index.html.twig', ['locations' => $locations]);
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

    #[Route('/add-mcs', name: 'mcs')]
    public function addMcs(Request $request, EntityManagerInterface $em)
    {
        $loc = [];
        $location = new Location();
        $form = $this->createForm(McsType::class, null);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData() as $formData) {
                $loc = $formData['__name__']->getLocation();
                unset($formData['__name__']);
                foreach($formData as $mc) {
                    $monthlyConsumption = new Mc();

                    $monthlyConsumption->setFamily($mc->getFamily());
                    $monthlyConsumption->setPg($mc->getPg());
                    $monthlyConsumption->setHostel($mc->getHostel());
                    $monthlyConsumption->setHotel($mc->getHotel());
                    $monthlyConsumption->setRestaurant($mc->getRestaurant());
                    $monthlyConsumption->setCategory($mc->getCategory());
                    $monthlyConsumption->setLocation($loc);
                    $em->persist($monthlyConsumption);
                }
            }

            $em->flush();
            $this->addFlash('message', 'Item(s) Added!');

            return $this->redirectToRoute('mcs');

        }
        return $this->render('admin/add_mcs.html.twig', [
            'form' => $form->createView()
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
        return $this->render('chart/location-based-data.html.twig', [
            'lists' => $lists
        ]);
    }
}
