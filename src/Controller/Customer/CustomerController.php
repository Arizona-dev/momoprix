<?php
namespace App\Controller\Customer;

use App\Form\ProfileType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    public function __construct(Security $security, EntityManagerInterface $manager, CustomerRepository $customerRepository)
    {
        $this->security = $security;
        $this->manager = $manager;
        $this->customerRepository = $customerRepository;
    }

    //Mon compte | modifier le profil
    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->security->getUser();
        $user->setUpdatedAt(new \DateTime());
        $oldPass = $user->getPassword();

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        // TODO
        // When form is Submitted and password field is empty there is an error : expected type "string", "null" given "password"
        // Also add empty fields checks
        if ($form->isSubmitted()) 
        {
            $plainPassword = $form->get('password')->getData();

            if ($plainPassword != null)  
            {
                if($form->get('password')->getData() === $form->get('confirmPassword')->getData()) 
                {
                    $hash = $encoder->encodePassword($user, $plainPassword);
                    $user->setPassword($hash);
                } else 
                {
                    $this->addFlash('danger', 'Les mots de passe ne correspondent pas!');
                    return $this->render('/customer/index.html.twig', [
                        'firstname' => $user->getFirstname(),
                        'lastname' => $user->getLastname(),
                        'email' => $user->getEmail(),
                        'number' => $user->getPhone(),
                        'form' => $form->createView()
                    ]);
                }
                
            } else 
            {
                $form->get('password')->setData($oldPass);
                $form->get('confirmPassword')->setData($oldPass);
            }
            
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('succes', 'Profil modifié avec succès!');
            return $this->render('/customer/index.html.twig', [
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'email' => $user->getEmail(),
                'number' => $user->getPhone(),
                'form' => $form->createView()
            ]);
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