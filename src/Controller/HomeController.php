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


class HomeController extends AbstractController
{


    /** //////////////////////////////////////////HOME////////////////////////////////////////////////////////
     * @Route("/", name="home")
     */
    public function home(CryptoInvestmentRepository $dailyGainRepository, CryptoWalletRepository $cryptoactifRepository): Response
    {
        ///////////////////gain affiche
        $value = count($dailyGainRepository->findAll());
        $data = $dailyGainRepository->find($value)->getGain();
        ///////////

        ///////////////////crypto actif
        $actif = $cryptoactifRepository->findBy(
            ['actif' => 1],
            ['price' => 'DESC']
        );
        /////////////

        return $this->render('home/home.html.twig', [
            'gain' => $data,
            'actif' => $actif
        ]);


    }

    }
