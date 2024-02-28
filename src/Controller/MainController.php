<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Organization;
use App\Repository\OrganizationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route("/", name: "homepage")]
    public function homepage(): Response
    {



       return $this->render("main/homepage.html.twig", [
        "title"=>"Homepage"
       ]);
    }

    #[Route("/add-offer", name: "addOffer")]
    public function add_offer(EntityManagerInterface $entityManager, OrganizationRepository $organizationRepository): Response{

        $organizations = $organizationRepository->findAll();

        $offer = new Offer();
        $form = $this->createFormBuilder($offer)
        ->add("title")
        ->add("desccription")
        ->add("init_date")
        ->add("finish_date")
        ->add("vacancy")
        ->add("id_organization")
        ->add("createdAt")
        ->add("lastUpdate")
        ->add("submit", SubmitType::class, ["label"=>"Add"])
        ->getForm();
 
        return $this->render("/main/addOffer.html.twig", [
            "title"=>"Add Offer",
            "organizationsArray"=>$organizations
        ]);
    }

    #[Route("add-organization", name:"addOrganization")]
    public function add_organization(EntityManagerInterface $entityManager): Response{
        $organization = new Organization;
        $organization->setName("Médicos sin Fronteras");
        $organization->setDescription("New ONG");
        $organization->setEmail("medicosSinFonteras@gmail.com");
        $organization->setPhone(null);
        $organization->setAddress("Fontiñas");
        $organization->setCountry("Spain");
        $organization->setCreatedAt(new \DateTimeImmutable());
        $organization->setLastUpdate(new \DateTimeImmutable());

        $entityManager->persist($organization);
        $entityManager->flush();

        return new Response(sprintf("Organization %d with name '%s'created", 
        $organization->getId(), $organization->getName()));
    }
}