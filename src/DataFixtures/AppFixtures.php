<?php

namespace App\DataFixtures;

use App\Entity\Job;
use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\Assigned;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;



require(__dir__.'/data/Jobs.php');
require(__dir__.'/data/Employees.php');
require(__dir__.'/data/Projects.php');


class AppFixtures extends Fixture
{

    private ObjectManager $manager;
    private $date;
    
    public function load( ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadJobs();
        $this->loadEmployees();
        $this->loadProjects();
        $this->loadAssigned();

        $manager->flush();
    }

    private function loadJobs(): void
    {
        foreach(DATA_JOBS as $key => [$jobname]){
            $job = (new Job())
                ->setName($jobname)
            ;
            $this->manager->persist($job);
            $this->addReference(Job::class .$key, $job);
        }
    }

    private function loadEmployees() : void
    {
        foreach(DATA_EMPLOYEES as $key => $employeeData){
            $job = $this->getReference(Job::class .random_int(0, count(DATA_JOBS) - 1));
            $date = new \DateTime('now');
            $employee = (new Employee())
                ->setFirstname($employeeData['firstname'])
                ->setLastname($employeeData['lastname'])
                ->setEmail($employeeData['email'])
                ->setCost($employeeData['cost'])
                ->setStartedJob($date)
                ->setJob($job);
            ;
            $this->manager->persist($employee);
            $this->addReference(Employee::class .$key, $employee);

            sleep(1);
        }
    }

    private function loadProjects() : void
    {
        
        foreach(DATA_PROJECTS as $key => $projectData){
            $date = new \DateTime('now');

            $project = (new Project())
                ->setName($projectData['name'])
                ->setDescription($projectData['description'])
                ->setPrice($projectData['price'])
                ->setCreateAt($date)
            ;
            $this->manager->persist($project);
            $this->addReference(Project::class .$key, $project);

            sleep(1);

        }
    }

    private function loadAssigned() : void
    {


        for($i = 0; $i < 21; $i++){
            $project = $this->getReference(Project::class .random_int(0, count(DATA_PROJECTS) - 1));
            $employee = $this->getReference(Employee::class .random_int(0, count(DATA_EMPLOYEES) - 1));
            $timeProduction = random_int(1,6);
            $date = new \DateTime('now');
            $assigne = (new Assigned())
                ->setProject($project)
                ->setEmployee($employee)
                ->setTimeProduction($timeProduction)
                ->setpublishedAt($date)
            ;
            $this->manager->persist($assigne);
            sleep(1);
        }
    }


}
