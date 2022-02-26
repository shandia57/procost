<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsController extends AbstractController{
    #[Route('/projects', name: "projects_page")]
    public function projectsPage(): Response
    {
        return $this->render('pages/projects/projects.html.twig');
    }
}