<?php 

namespace App\Controller\employees;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeCreateController extends AbstractController{
    #[Route('/employees/create', name: "employees_create_page")]
    public function employeesCreatePage(): Response
    {
        return $this->render('pages/employees/employees_create.html.twig');
    }
}