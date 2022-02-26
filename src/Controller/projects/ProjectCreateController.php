<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectCreateController extends AbstractController{
    #[Route('/projects/create', name: "project_create")]
    public function projectsCreatePage(): Response
    {
        return $this->render('pages/projects/project_create.html.twig');
    }
}

