<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Entity\Property;
use App\Entity\MonthlyConsumption;
use App\Form\MonthlyConsumptionType;
use App\Form\CategoryType;
use App\Form\SubCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(): Response
    {
        return $this->render('chart/index.html.twig', [
            'controller_name' => 'ChartController',
        ]);
    }

    #[Route('/add-category', name:'add-category')]
    public function addCategory(Request $request, EntityManagerInterface $em)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
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
        if($form->isSubmitted() && $form->isValid()){
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

    #[Route('/add-mc', name: 'mc')]
    public function addMc(Request $request)
    {
        $monthlyConsumption = new MonthlyConsumption();
        $form = $this->createForm(MonthlyConsumptionType::class, $monthlyConsumption);
        $form->handleRequest($request);
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
}   
