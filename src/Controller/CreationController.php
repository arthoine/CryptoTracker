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


class CreationController extends AbstractController
{



    /**  ////////////////////////////////////////////////////DEBUT CREATION////////////////////////////////////////////////////////////////////////////////////
     * @Route("/ajout/market")
     * création base market
     */
    public function ajoutMarket(ManagerRegistry $doctrine, CallApiService $callApiService): Response
    {
        $datas = $callApiService->getCrypto();
        //dd($datas);

        $entityManager = $doctrine->getManager();
        $val = 0 ;
        foreach ($datas["data"] as $key => $value) {
            echo $datas["data"][$key]["name"], ' = ', $datas["data"][$key]["quote"]["EUR"]["price"], "<br>";
            $a = new CryptoMarket();
            $a->setName($datas["data"][$key]["name"]);
            $a->setPrice($datas["data"][$key]["quote"]["EUR"]["price"]);
            $entityManager->persist($a);
            $entityManager->flush();
        }
        return $this->render('bdd/AddBdd.html.twig', [
            'datas' => $callApiService->getCrypto(),
        ]);

    }
    /**
     * @Route("/ajout/wallet")
     * création base wallet
     */

    public function ajoutWallet(ManagerRegistry $doctrine, CallApiService $callApiService): Response
    {
        $datas = $callApiService->getCrypto();
        //dd($datas);

        $entityManager = $doctrine->getManager();
        $val = 0 ;
        foreach ($datas["data"] as $key => $value) {
            echo $datas["data"][$key]["name"], ' = ', $datas["data"][$key]["quote"]["EUR"]["price"], "<br>";
            $a = new CryptoWallet();
            $a->setName($datas["data"][$key]["name"]);
            $a->setQuantity(0);
            $a->setPrice($datas["data"][$key]["quote"]["EUR"]["price"]);
            $a->setSymbol($datas["data"][$key]["symbol"]);
            $a->setActif(false);
            $a->setCoef("0");
            $entityManager->persist($a);
            $entityManager->flush();
        }
        return $this->render('bdd/AddBdd.html.twig', [
            'datas' => $callApiService->getCrypto(),
        ]);

    }
    /**  ////////////////////////////////////////////////////FIN CREATION////////////////////////////////////////////////////////////////////////////////////// */
}
