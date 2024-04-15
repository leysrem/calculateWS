<?php

namespace App\Controller;

use App\Entity\Result;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalculateServiceController extends AbstractController
{
    public static function addition($value1, $value2) 
    {
        $result = $value1 + $value2;
        return $result;
    }

    public static function subtraction($value1, $value2) 
    {
        $result = $value1 - $value2;
        return $result;
    }

    public static function division($value1, $value2) 
    {
        $result = $value1 / $value2;
        return $result;
    }

    public static function multiplication($value1, $value2) 
    {
        $result = $value1 * $value2;
        return $result;
    }

    public static function history(EntityManagerInterface $entityManager)
    {  
        $query = $entityManager->createQuery 
        (
            'SELECT r.number
            FROM App\Entity\Result r
            ORDER BY r.id DESC'
        ); 
        $query->setMaxResults(5);
        $results = $query->getResult();
        return $results;
    }

    #[Route('/calculate', name: 'app_calculate_service')]
    public function calculate(EntityManagerInterface $entityManager, Request $request)
    {  
        $value1 = $request->query->get('value1');
        $value2 = $request->query->get('value2');
        $operators = $request->query->get('operator');
        $result = null;
        $results = [];
        
        switch ($operators) 
        {
            case '+':
                $result = self::addition($value1,$value2);            
                break;
            case '-':
                $result = self::subtraction($value1,$value2);
                break;
            case '/':
                $result = self::division($value1,$value2);
                break;
            case '*':
                $result = self::multiplication($value1,$value2);
                break;     
            case 'h':
                $results = self::history($entityManager);
                break;
            default:           
        } 

        if ($result !== null) 
        {
            $resultCalcul = new Result();
            $resultCalcul->setNumber($result);
            $entityManager->persist($resultCalcul);
            $entityManager->flush();  
        }
        
        return $this->render('calculate_service/index.html.twig', [
            'result' => $result,
            'results' => $results,
        ]);
    }
}
