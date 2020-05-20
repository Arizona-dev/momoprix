<?php
namespace App\Controller\Customer;

use App\Form\ProfileType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    public function __construct(Security $security, EntityManagerInterface $manager)
    {
        $this->security = $security;
        $this->manager = $manager;
    }

    //Mon compte | modifier le profil
    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request)
    {
        $user = $this->security->getUser();
        $user->setUpdatedAt(new \DateTime());

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $plainPassword = $form->get('password')->getData();
            dd($plainPassword);


            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('succes', 'Profil modifié avec succès!');
            return $this->redirectToRoute('profile');
        }

        return $this->render('/customer/index.html.twig', [
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),
            'number' => $user->getPhone(),
            'form' => $form->createView()
        ]);
    }

    // Mes commandes
    /**
     * @Route("/profile/orders", name="profile_orders")
     */
    public function orders()
    {
        return $this->render('/customer/orders.html.twig');
    }

    // Mes factures
    /**
     * @Route("/profile/receipts", name="profile_receipts")
     */
    public function receipts()
    {
        return $this->render('/customer/receipts.html.twig');
    }

    //Mes adresses
    /**
     * @Route("/profile/address", name="profile_addresses")
     */
    public function addresses()
    {
        return $this->render('/customer/addresses.html.twig');
    }

    //Moyens de paiements
    /**
     * @Route("/profile/payments", name="profile_payments")
     */
    public function payments()
    {
        return $this->render('/customer/payments.html.twig');
    }



}