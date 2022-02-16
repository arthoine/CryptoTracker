<?php

namespace App\Controller;

use App\Entity\CryptoInvestment;
use App\Entity\CryptoMarket;
use App\Entity\CryptoWallet;
use App\Entity\Transaction;
use App\Form\TransacType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     */
    public function index( Request $request): Response
    {
        $Transaction = new Transaction();

        $form = $this->createForm(TransacType::class, $Transaction);
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
            $set = (( $Transaction->getQuantity() * $Transaction->getPrice() )+( $product->getQuantity() * $product->getPrice() )) / ( $Transaction->getQuantity() + $product->getQuantity() ) ;
            //echo $set;
            //dd($Transaction);

            $product->setQuantity($product->getQuantity() + $Transaction->getQuantity());
            $product->setPrice( $set );
            $product->setActif( "1" );
            ////////////////////////////// COEF MODIF
            $tarif = $entityManager->getRepository(CryptoMarket::class)->findOneBy([
                'name' => $value,
            ]);
            if(      ($tarif->getPrice() - $product->getPrice()  ) >= 100 ){
                    echo "2 <br/>";
                $product->setCoef("2");

            }elseif (($tarif->getPrice() - $product->getPrice()  ) >= 0){
                    echo "1<br/>";
                $product->setCoef("1");

            }elseif (($tarif->getPrice() - $product->getPrice()  ) <= -100 ){
                    echo "-2 <br/>";
                $product->setCoef("-2");

            }elseif (($tarif->getPrice() - $product->getPrice()  ) <= -0){
                    echo "-1 <br/>";
                $product->setCoef("-1");


            }
            //////////////////////////
            $entityManager->persist($product);
            $entityManager->persist($Transaction);
            $entityManager->flush();


            return $this->redirectToRoute('vue');
        }

        return $this->render('add/add.html.twig', [
            'controller_name' => 'AddController',
            'form' => $form->createView(),
        ]);
    }
}