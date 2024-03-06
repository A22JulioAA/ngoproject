<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Repository\OfferRepository;
use App\Repository\OrganizationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganizationsController extends AbstractController
{
    #[Route("/organizations-panel", name: "organizations-panel")]
    public function organizationsPanel(OfferRepository $offerRepository, OrganizationRepository $organizationRepository): Response
    {

        // This show a twig template with all the offers and organizations queried the database.

        $arrayOffers = $offerRepository->findAll();
        $arrayOrganizations = $organizationRepository->findAll();

        return $this->render("./main/organizations-panel.html.twig", [
            "title" => "Organizations Panel",
            "offers" => $arrayOffers,
            "organizations" => $arrayOrganizations
        ]);
    }

    #[Route("/organizations-panel-delete-offer/{id}", name: "delete-offer")]
    public function deleteOffer(int $id, OfferRepository $offerRepository, EntityManagerInterface $entityManager): Response
    {

        // I take the id in the URL and find the offer with it in the database. Then I removed and send a flash messagge.

        $offer = $offerRepository->find($id);

        if (!$offer) {
            $this->addFlash("unsuccessful", "Offer doesn't exist");
            return $this->redirectToRoute('organizations-panel');
        }

        try {
            $entityManager->remove($offer);
            $entityManager->flush();

            $this->addFlash("success", "Offer deleted successfuly!🗑️");
        } catch (Exception $e) {
            $this->addFlash("error", "Offer canno't be removed.💔");
        }

        return $this->redirectToRoute("organizations-panel");
    }

    #[Route("/organizations-panel-update-offer/{id}", name: "update-offer")]
    public function updateOffer(int $id, Request $request, EntityManagerInterface $entityManager, OfferRepository $offerRepository): Response
    {

        // I take the id in the URL and find the offer with it in the database. Then I load a form to update it.

        $offer = $offerRepository->find($id);

        $form = $this->createFormBuilder($offer)
            ->add("title", null, [
                "label" => "Title: ",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("description", null, [
                "label" => "Description: ",
                "attr" => [
                    "rows" => 10,
                    "cols" => 40,
                    "class" => "input"
                ]
            ])
            ->add("init_date", null, [
                "label" => "Init Date:",
                "attr" => [
                    "class" => "inputTime"
                ]
            ])
            ->add("finish_date", null, [
                "label" => "Finish Date:",
                "attr" => [
                    "class" => "inputTime"
                ]
            ])
            ->add("vacancy", null, [
                "label" => "Vacancies:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("id_organization", EntityType::class, [
                "class" => Organization::class,
                "choice_label" => "name",
                "label" => "Organization:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("termsAndConditions", CheckboxType::class, [
                "mapped" => false,
                "label" => "I have read and accept all terms and conditions.",
                "required" => true
            ])
            ->add("submit", SubmitType::class, ["label" => "Add", "attr" => [
                "class" => "submitButton"
            ]])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash("success", "Your offer has been updated");

            return $this->redirectToRoute("homepage");
        }
        return $this->render("/manageOffersOrganizations/updateOffer.html.twig", [
            "title" => "Update Offer",
            "form" => $form
        ]);
    }

    #[Route("/organizations-panel-delete-organization/{id}", name: "delete-organization")]
    public function deleteOrganization(int $id, EntityManagerInterface $entityManager, OrganizationRepository $organizationRepository): Response
    {

        // I take the id in the URL and find the organization with it in the database. Then I removed and send a flash messagge.

        $organization = $organizationRepository->find($id);

        if (!$organization) {
            $this->addFlash("unsuccessful", "Organization doesn't exist");
            return $this->redirectToRoute('organizations-panel');
        }

        try {
            $entityManager->remove($organization);
            $entityManager->flush();

            $this->addFlash("success", "Organization deleted successfuly!🗑️");
        } catch (Exception $e) {
            $this->addFlash("error", "This organization can't be removed because some offer are active.💔");
        }
        return $this->redirectToRoute("organizations-panel");
    }

    #[Route("/organizations-panel-update-organization/{id}", name: "update-organization")]
    public function updateOrganization(Request $request, int $id, EntityManagerInterface $entityManager, OrganizationRepository $organizationRepository): Response
    {

        // I take the id in the URL and find the organization with it in the database. Then I load a form to update it.

        $organization = $organizationRepository->find($id);

        $form = $this->createFormBuilder($organization)
            ->add("name", null, [
                "label" => "Name: ",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("description", null, [
                "label" => "Description: ",
                "attr" => [
                    "rows" => 10,
                    "cols" => 40,
                    "class" => "input"
                ]
            ])
            ->add("email", null, [
                "label" => "Email: ",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("phone", null, [
                "label" => "Phone:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("address", null, [
                "label" => "Address:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("country", null, [
                "label" => "Country:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("termsAndConditions", CheckboxType::class, [
                "mapped" => false,
                "label" => "I have read and accept all terms and conditions.",
                "required" => true
            ])
            ->add("submit", SubmitType::class, ["label" => "Add", "attr" => [
                "class" => "submitButton"
            ]])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash("success", "Organization has been updated.");
            return $this->redirectToRoute("homepage");
        }
        return $this->render("/manageOffersOrganizations/updateOrganization.html.twig", [
            "title" => "Update Organization",
            "form" => $form
        ]);
    }
}
