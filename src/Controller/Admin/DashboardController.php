<?php

namespace App\Controller\Admin;

use App\Entity\Animation;
use App\Entity\AnimationStudio;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Type;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        return $this->render('admin/dashboard.html.twig');

    }

    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('DashBoard Admin');

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Home', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fa fa-user-circle', User::class);
        yield MenuItem::linkToCrud('Episodes', 'fa fa-television', Episode::class);
        yield MenuItem::linkToCrud('Animations', 'fa fa-film', Animation::class);
        yield MenuItem::linkToCrud('Animation Studios', 'fa fa-video-camera', AnimationStudio::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class);
        yield MenuItem::linkToCrud('Types', 'fa fa-list-alt', Type::class);

    }

}
