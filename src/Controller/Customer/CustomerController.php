<?php
namespace App\Controller\Customer;

use App\Entity\Address;
use App\Form\AddressType;
use App\Form\ProfileType;
use App\Repository\AddressRepository;
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

    /**
     * @var AddressRepository
     */
    protected $addressRepository;

    public function __construct(Security $security, EntityManagerInterface $manager, CustomerRepository $customerRepository, AddressRepository $addressRepository)
    {
        $this->security = $security;
        $this->manager = $manager;
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;
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

        $profile_form = $this->createForm(ProfileType::class, $user);
        $profile_form->handleRequest($request);
        // TODO
        // When form is Submitted and password field is empty there is an error : expected type "string", "null" given "password"
        // Also add empty fields checks
        if ($profile_form->isSubmitted()) 
        {
            $plainPassword = $profile_form->get('password')->getData();

            if ($plainPassword != null)  
            {
                if($profile_form->get('password')->getData() === $profile_form->get('confirmPassword')->getData()) 
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
                        'profile_form' => $profile_form->createView()
                    ]);
                }
                
            } else 
            {
                $profile_form->get('password')->setData($oldPass);
                $profile_form->get('confirmPassword')->setData($oldPass);
            }
            
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('succes', 'Profil modifié avec succès!');
            return $this->render('/customer/index.html.twig', [
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'email' => $user->getEmail(),
                'number' => $user->getPhone(),
                'profile_form' => $profile_form->createView()
            ]);
        }

        return $this->render('/customer/index.html.twig', [
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),
            'number' => $user->getPhone(),
            'profile_form' => $profile_form->createView()
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
    public function addresses(Request $request)
    {
        $address = new Address();
        $user = $this->security->getUser();
        $address->setCustomerId($user);
        
        $getAddress = $this->addressRepository->findAllAddressById($user->getId());

        $address_form = $this->createForm(AddressType::class, $address);

        $address_form->handleRequest($request);
        
        if ($address_form->isSubmitted()) 
        {
            $this->manager->persist($address);
            $this->manager->flush();
            $this->addFlash('succes', 'Adresse ajouté avec succès!');
            return $this->render('/customer/addresses.html.twig', [
            'address_form' => $address_form->createView(),
            'address_list' => $getAddress
            ]);
        }

        return $this->render('/customer/addresses.html.twig', [
            'address_form' => $address_form->createView(),
            'address_list' => $getAddress
        ]);
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