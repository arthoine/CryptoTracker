<?php

namespace App\Controller;

use App\Entity\CryptoInvestment;
use App\Repository\CryptoInvestmentRepository;
use App\Entity\CryptoMarket;
use App\Entity\CryptoWallet;
use App\Entity\CryptoMarketRepository;
use App\Repository\CryptoWalletRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


use App\Service\CallApiService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Persistence\ManagerRegistry;


class VueController extends AbstractController
{


    /** //////////////////////////////////////////CREATION DU BENEFICE/PERTE PLUS COEF////////////////////////////////////////////////////////
     * @Route("/vue", name="vue")
     */

    public function vue(ManagerRegistry $doctrine, CallApiService $callApiService): Response
    {
        $val = 0;
        $entityManager = $doctrine->getManager();
        $prime = $entityManager->getRepository(CryptoWallet::class)->findall();
        $tarif = $entityManager->getRepository(CryptoMarket::class)->findall();
        //dd($prime);
        foreach ($prime as $key => $value) {
            if ( $prime[$key]->getQuantity() > 0 ){

                //$val = $val + $prime[$key]["quantity"]*$prime["price"];
                //echo "quantité/prix : ",$prime[$key]->getQuantity()," : ",$prime[$key]->getPrice(),"<br/>";
                $val = $val + ($prime[$key]->getQuantity() * $tarif[$key]->getPrice()) - ($prime[$key]->getQuantity() * $prime[$key]->getPrice());
                //echo $val,"<br/>";
            }
        }

        $a = new CryptoInvestment();
        $a->setGain($val);
        $a->setDate(new \DateTime('now'));
        $entityManager->persist($a);
        $entityManager->flush();


        $datas = $entityManager->getRepository(CryptoWallet::class)->findAll();

        foreach ($datas as $key => $value) {
            if ($datas[$key]->getQuantity()>0){
                $prod = $entityManager->getRepository(CryptoWallet::class)->findOneBy(['name' => $datas[$key]->getName()]);
                //dd ($datas);
                //dd($entityManager->getRepository(CryptoWallet::class)->findOneBy(['name' => $datas[$key]->getName()]));
                if(      ($tarif[$key]->getPrice() - $datas[$key]->getPrice()  ) >= 100 ){
                    //echo "2 <br/>";
                    $prod->setCoef("2");

                }elseif (($tarif[$key]->getPrice() - $datas[$key]->getPrice()  ) >= 0){
                    //echo "1<br/>";
                    $prod->setCoef("1");

                }elseif ( ($tarif[$key]->getPrice() - $datas[$key]->getPrice()  ) <= -100 ){
                    //echo "-2 <br/>";
                    $prod->setCoef("-2");

                }elseif (($tarif[$key]->getPrice() - $datas[$key]->getPrice()  ) <= -0){
                    //echo "-1 <br/>";
                    $prod->setCoef("-1");


                }
                $entityManager->persist($prod);
                $entityManager->flush();


                /*$product->setCoef();
                $entityManager->persist($product);
                $entityManager->flush();*/
            }
        }

        return $this->redirectToRoute('home');


    }


}
