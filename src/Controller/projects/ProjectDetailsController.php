<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectDetailsController extends AbstractController{
    #[Route('/projects/details', name: "project_details_page")]
    public function projectsPage(): Response
    {
        return $this->render('pages/projects/project_details.html.twig');
    }
}