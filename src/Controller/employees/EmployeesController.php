<?php 

namespace App\Controller\employees;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeesController extends AbstractController{
    #[Route('/employees', name: "employees_page")]
    public function employeesPage(): Response
    {
        return $this->render('pages/employees/employees.html.twig');
    }
}