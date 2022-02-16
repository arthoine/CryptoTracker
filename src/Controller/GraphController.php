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


class GraphController extends AbstractController
{


    /** //////////////////////////////////////////GRAPH GAIN////////////////////////////////////////////////////////
     * @Route("/graph", name="graph")
     */
    public function graph(CryptoInvestmentRepository $dailyResultRepository, ChartBuilderInterface $chartBuilder): Response
    {

        $dailyResults = $dailyResultRepository->findAll();

        $labels = [];
        $data = [];

        foreach ($dailyResults as $dailyResult) {
            $labels[] = $dailyResult->getDate()->format('d/m/Y');
            $data[] = $dailyResult->getGain();
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Vos gains',
                    'backgroundColor' => 'rgb(100,195,108)',
                    'borderColor' => 'rgb(100,195,108)',
                    'data' => $data,

                ],
            ],
        ]);


        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);


        return $this->render('graph/graph.html.twig', [
            'controller_name' => 'HomeController',
            'chart' => $chart,


            //'datas' => $callApiService->getCrypto(),
        ]);


    }


}
