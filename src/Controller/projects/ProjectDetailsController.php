<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;

class ProjectDetailsController extends AbstractController{

    public function __construct( private ProjectRepository $projectRepo)
    {
        
    }

    #[Route('/projects/details/{id}', name: "project_details")]
    public function projectsDetailsPage(int $id): Response
    {
        $project = $this->projectRepo->find($id);
        return $this->render('pages/projects/project_details.html.twig', [
            'project' => $project,
        ]);

    }
}