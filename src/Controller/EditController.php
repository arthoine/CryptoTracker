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


class EditController extends AbstractController
{

    /** //////////////////////////////////////////FICHIER CRON////////////////////////////////////////////////////////
     * @Route("/edit", name="edit")
     */
    public function edit(ManagerRegistry $doctrine, CallApiService $callApiService): Response
    {
        $datas = $callApiService->getCrypto();
        //dd($datas);

        $entityManager = $doctrine->getManager();
        foreach ($datas["data"] as $key => $value) {
            //echo $datas["data"][$key]["name"], ' = ', $datas["data"][$key]["quote"]["EUR"]["price"], "<br>";
            $product = $entityManager->getRepository(CryptoMarket::class)->findOneBy(['name' => $datas["data"][$key]["name"]]);
            //dd($product);
            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id '
                );
            }
            $product = $entityManager->getRepository(CryptoMarket::class)->find($product->getid());
            $product->setName($datas["data"][$key]["name"]);
            $product->setPrice($datas["data"][$key]["quote"]["EUR"]["price"]);
            $entityManager->persist($product);
            $entityManager->flush();

        }

        return $this->redirectToRoute('vue');

    }


}
