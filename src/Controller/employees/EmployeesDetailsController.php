<?php 

namespace App\Controller\employees;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeesDetailsController extends AbstractController{
    #[Route('/employees/details', name: "employees_details_page")]
    public function employeesDetailsPage(): Response
    {
        return $this->render('pages/employees/employees_details.html.twig');
    }
}