<?php 

namespace App\Controller\jobs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobsCreateController extends AbstractController{
    #[Route('/jobs/create', name: "jobs_create")]
    public function projectsCreatePage(): Response
    {
        return $this->render('pages/jobs/jobs_create.html.twig');
    }
}