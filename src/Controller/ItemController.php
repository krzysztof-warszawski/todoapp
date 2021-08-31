<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/items", name="items.")
 */
class ItemController extends AbstractController
{
    /**
     * @Route("/list", name="index")
     */
    public function index(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findAll();

        return $this->render('item/index.html.twig', [
            'items' => $items,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"}))
     */
    public function create(Request $request): Response
    {
        $item = new Item();

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('items.index');
        }


        return $this->render('item/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update($id, ItemRepository $itemRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $item = $itemRepository->find($id);
        $item->setCompleted(true);
        $item->setCompletedAt(new \DateTime());

        $entityManager->flush();

        $this->addFlash('success','The task has been completed');

        return $this->redirectToRoute('items.index');
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"}))
     */
    public function remove($id, ItemRepository $itemRepository): Response
    {
        $item = $itemRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($item);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }


}
