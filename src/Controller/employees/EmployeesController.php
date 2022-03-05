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

    #[Route('/employees', name: "employees")]
    public function employeesPage(): Response
    {
        $employees = $this->employeeRepo->getAllEmployeeByDesc();
        return $this->render('pages/employees/employees.html.twig', [
            "employees" => $employees,
        ]);
    }


}