<?php 

namespace App\Controller\jobs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobsController extends AbstractController{
    #[Route('/jobs', name: "jobs")]
    public function projectsPage(): Response
    {
        return $this->render('pages/jobs/jobs.html.twig');
    }
}