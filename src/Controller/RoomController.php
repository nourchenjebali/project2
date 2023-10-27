<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'app_room')]
    public function index(): Response
    {
        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }

    #[Route('/showdbroom', name: 'showdbroom')]
    public function showdbroom(RoomRepository $roomRepository): Response
    {
        $room= $roomRepository->findAll();
        return $this->render('room/showdbroom.html.twig', [
            'room' => $room
        ]);
    }

    #[Route('/addroom', name: 'addroom')]
    public function addroom(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $em= $managerRegistry->getManager();
        $room= new Room();
        $form=$this->createForm(RoomType::class, $room);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()){
            $em->persist($room);
            $em->flush();
            return $this->redirect('showdbroom');
        }
        return $this->renderForm('room/addroom.html.twig', [
            'f' => $form
        ]);
    }
    #[Route('/editroom/{id}', name: 'editroom')]
    public function editroom($id,RoomRepository $roomRepository ,ManagerRegistry $managerRegistry ,Request $req): Response
    {
        //var_dump($id).die;
        $em= $managerRegistry->getManager();
        $dataid=$roomRepository->find($id);
        //var_dump($dataid).die;
        $form=$this->createForm(RoomType::class,$dataid);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()){
            $em->persist($dataid);
            $em->flush();
            return $this->redirectToRoute('showdbroom');
        }
        return $this->renderForm('room/editroom.html.twig', [
            'form' => $form
        ]);
    } 

    #[Route('/deleteroom/{id}', name: 'deleteroom')]
    public function deleteroom($id, ManagerRegistry $managerRegistry, RoomRepository $roomRepository): Response
    {
        $em=$managerRegistry->getManager();
        $id=$roomRepository->find($id);
        $em->remove($id);
        $em->flush();
    
     return $this->redirectToRoute('showdbroom');
    }
}
