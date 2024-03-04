<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Offer;
use App\Entity\Organization;
use App\Repository\OfferRepository;
use App\Repository\OrganizationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganizationsController extends AbstractController
{
    #[Route("/organizations-panel", name:"organizations-panel")]
    public function organizationsPanel(OfferRepository $offerRepository, OrganizationRepository $organizationRepository): Response{

        $arrayOffers = $offerRepository->findAll();
        $arrayOrganizations = $organizationRepository->findAll();

        return $this->render("./main/organizations-panel.html.twig", [
            "title"=>"Organizations Panel",
            "offers"=>$arrayOffers,
            "organizations"=>$arrayOrganizations
        ]);
    }

    #[Route("/organizations-panel-delete-offer/{id}", name:"delete-offer")]
    public function deleteOffer(int $id, OfferRepository $offerRepository, EntityManagerInterface $entityManager): Response{

        $offer = $offerRepository->find($id);

        if(!$offer){
            $this->addFlash("unsuccessful", "Offer doesn't exist");
            return $this->redirectToRoute('organizations-panel');
        }

        $entityManager->remove($offer);
        $entityManager->flush();

        // return $this->redirectToRoute("organizations-panel");
        
        return $this->render("/manageOffersOrganizations/deleteOffer.html.twig", [
            "title"=>"Delete Offer"
        ]);
    }

    #[Route("/organizations-panel-update-offer/{id}", name:"update-offer")]
    public function updateOffer(int $id): Response{
        return $this->render("/manageOffersOrganizations/updateOffer.html.twig", [
            "title"=>"Delete Offer"
        ]);
    }

    #[Route("/organizations-panel-delete-organization/{id}", name:"delete-organization")]
    public function deleteOrganization(int $id): Response{
        return $this->render("/manageOffersOrganizations/deleteOrganization.html.twig", [
            "title"=>"Delete Offer"
        ]);
    }

    #[Route("/organizations-panel-update-organization/{id}", name:"update-organization")]
    public function updateOrganization(int $id): Response{
        return $this->render("/manageOffersOrganizations/updateOrganization.html.twig", [
            "title"=>"Delete Offer"
        ]);
    }
}
