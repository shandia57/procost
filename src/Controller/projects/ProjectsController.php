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

    #[Route('/projects?page={page}', name: "projects")]
    public function projectsPage(int $page): Response
    {
        $projects = $this->projectRepo->getAllProjectByDesc();
        $newArray = array_chunk($projects,10);
        
        return $this->render('pages/projects/projects.html.twig', [
            'projects' => $newArray[$page]??null,
            "numberPage" =>$newArray,
            "currentPage" => $page + 1,
            "page" => $page,
            "minPage" => 0,
            "maxPage" => count($newArray),
        ]);
    }

}