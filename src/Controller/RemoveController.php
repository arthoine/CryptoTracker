<?php

namespace App\Controller;

use App\Entity\CryptoWallet;
use App\Entity\Transaction;

use App\Form\SellType;
use App\Form\TransacType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoveController extends AbstractController
{
    /**
     * @Route("/remove", name="remove")
     */
    public function index( Request $request): Response
    {
        $Transaction = new Transaction();

        $form = $this->createForm(SellType::class, $Transaction);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            /*echo ($Transaction->getName());
            echo ($Transaction->getQuantity());
            echo ($Transaction->getPrice());*/
            $value= $Transaction->getName()->getName();
            //echo $value;

            $product = $entityManager->getRepository(CryptoWallet::class)->findOneBy([
                'name' => $value,

            ]);
            //dd ($product);
            $set = $product->getQuantity() -  $Transaction->getQuantity() ;
            if ($set <=0){
                $set =0;
            }
            //echo $set;
            //dd($Transaction);
            if ($set==0){
                $product->setActif( "0" );
            }
            $product->setQuantity( $set );
            $entityManager->persist($product);
            $entityManager->persist($Transaction);
            $entityManager->flush();

            return $this->redirectToRoute('vue');
        }

        return $this->render('remove/remove.html.twig', [
            'controller_name' => 'AddController',
            'form' => $form->createView(),
        ]);
    }
}