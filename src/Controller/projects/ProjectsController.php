<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;

class ProjectsController extends AbstractController{

    public function __construct( private ProjectRepository $projectRepo)
    {
        
    }

    #[Route('/projects', name: "projects")]
    public function projectsPage(): Response
    {
        $projects = $this->projectRepo->findAll();
        return $this->render('pages/projects/projects.html.twig', [
            'projects' => $projects,
        ]);
    }
}