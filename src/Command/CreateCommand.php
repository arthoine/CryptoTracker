<?php

namespace App\Command;

use App\Entity\CryptoInvestment;
use App\Entity\CryptoMarket;
use App\Entity\CryptoWallet;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Entity\CryptoMarketRepository;

use App\Service\CallApiService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\Persistence\ManagerRegistry;

class CreateCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create';

    protected function configure(): void
    {
        // ...
    }
    private $ManagerRegistry;
    private $CallApiService;
    public function __construct( ManagerRegistry $ManagerRegistry, CallApiService $CallApiService)
    {
        $this->ManagerRegistry = $ManagerRegistry;
        $this->CallApiService = $CallApiService;

        parent::__construct();
    }

    protected function execute( InputInterface $input, OutputInterface $output): int
    {
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        ////////////////////////////////////////////////////////////EDIT///////////////////////////////////////////////////////////
        $datas = $this->CallApiService->getCrypto();
        //dd($datas);

        $entityManager = $this->ManagerRegistry->getManager();
        foreach ($datas["data"] as $key => $value) {
            //echo $datas["data"][$key]["name"], ' = ', $datas["data"][$key]["quote"]["EUR"]["price"], "<br>";
            $product = $entityManager->getRepository(CryptoMarket::class)->findOneBy(['name' => $datas["data"][$key]["name"]]);
            //dd($product);

            $product = $entityManager->getRepository(CryptoMarket::class)->find($product->getid());
            $product->setName($datas["data"][$key]["name"]);
            $product->setPrice($datas["data"][$key]["quote"]["EUR"]["price"]);
            $entityManager->persist($product);
            $entityManager->flush();

        }
        ////////////////////////////////////////////////////////////VUE///////////////////////////////////////////////////////////
        $val = 0;
        $entityManager = $this->ManagerRegistry->getManager();
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
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output->writeln([
            'Commande envoyée !',

        ]);
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}