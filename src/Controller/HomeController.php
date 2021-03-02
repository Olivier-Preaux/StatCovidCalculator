<?php

namespace App\Controller;

use App\Service\CallApiService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilder;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index( CallApiService $callApiService , ChartBuilderInterface $chartBuilder ): Response
    {   

        $label=[];
        $hospitalisation =[];
        $rea = [] ;

        for ( $i=1 ; $i<8 ; $i++ ){
            $date = new DateTime('- '.$i.' day');
            $datas = $callApiService->getAllDataByDate(($date->format('Y-m-d')));
            
            foreach ($datas['allFranceDataByDate'] as $data ){
                
                    if ($data['nom'] === 'France' ){
                        $label[]=$data['date'];
                        $hospitalisation[]=$data['nouvellesHospitalisations'];
                        $rea[]=$data['nouvellesReanimations'];
                        break;
                    }
            }
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels'=>array_reverse($label),
            'datasets' => [
                [
                        'label' => 'Nouvelles Hospitalisations',
                        'borderColor' => 'rgb(255,99,132)',
                        'data'=>array_reverse($hospitalisation),
                ],
                [
                        'label' => 'Nouvelles entrées en Réa',
                        'borderColor' => 'rgb(46,41,78)' ,
                        'data' => array_reverse($rea),
                ],
            ],
        ]);

        $chart->setOptions([/* ... */]);
        

        return $this->render('home/index.html.twig', [
            'data' => $callApiService->getFranceData(),
            'departments' => $callApiService->getAllData() ,
            'chart' => $chart,
        ]);
    }
}
