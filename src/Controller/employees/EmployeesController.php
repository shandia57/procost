<?php 

namespace App\Controller\employees;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EmployeeRepository;

class EmployeesController extends AbstractController{

    public function __construct( private EmployeeRepository $employeeRepo)
    {
        
    }

    #[Route('/employees?page={page}', name: "employees")]
    public function employeesPage(int $page): Response
    {

        $employees = $this->employeeRepo->getAllEmployeeByDesc();
        $newArray = array_chunk($employees,10);


        return $this->render('pages/employees/employees.html.twig', [
            "employees" => $newArray[$page]??null,
            "numberPage" =>$newArray,
            "currentPage" => $page + 1,
            "page" => $page,
            "minPage" => 0,
            "maxPage" => count($newArray) ,
        ]);
    }


}