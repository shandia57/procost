<?php 

namespace App\Controller\jobs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\JobRepository;

class JobsController extends AbstractController{

    public function __construct( private JobRepository $jobRepo)
    {
        
    }

    #[Route('/jobs?page={page}', name: "jobs")]
    public function projectsPage(int $page): Response
    {
        $jobs = $this->jobRepo->findAll();
        $newArray = array_chunk($jobs,10);
        return $this->render('pages/jobs/jobs.html.twig', [
            'jobs' => $newArray[$page]??null,
            "numberPage" =>$newArray,
            "currentPage" => $page + 1,
            "page" => $page,
            "minPage" => 0,
            "maxPage" => count($newArray) ,
        ]);
    }
}