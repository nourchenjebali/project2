<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(): Response
    {
        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }
    #[Route('/showdbcar', name: 'showdbcar')]
    public function showdbcar(CarRepository $carRepository): Response
    {
        $car =$carRepository->findAll();
        //var_dump($car).die;
        return $this->render('car/showdbcar.html.twig', [
            'car' => $car
        ]);
    }

    #[Route('/addcar', name: 'addcar')]
    public function addcar(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $em= $managerRegistry->getManager();
        $car= new Car();
        $form=$this->createForm(CarType::class,$car);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()){
            $em->persist($car);
            $em->flush();
            return $this->redirectToRoute('showdbcar');
        }
        return $this->renderForm('car/addcar.html.twig', [
            'f' => $form
        ]);
    }

    #[Route('/editcar/{id}', name: 'editcar')]
    public function editcar($id ,ManagerRegistry $managerRegistry, Request $req, CarRepository $carRepository): Response
    {
        //var_dump($id).die;
        $em= $managerRegistry->getManager();
        $dataid= $carRepository->find($id);
        //var_dump($dataid).die;
        $form=$this->createForm(CarType::class, $dataid);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()){
            $em->persist($dataid);
            $em->flush();
            return $this->redirectToRoute('showdbcar');
        }
        return $this->renderForm('car/editcar.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/deletecar/{id}', name: 'deletecar')]
    public function deletecar($id ,ManagerRegistry $managerRegistry, CarRepository $carRepository): Response
    {
        $em= $managerRegistry->getManager();
        $id= $carRepository->find($id);
        $em->remove($id);
        $em->flush();
       return $this->redirectToRoute('showdbcar');
    }
}
