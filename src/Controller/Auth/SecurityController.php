<?php
namespace App\Controller\Auth;

use App\Entity\Customer;
use App\Form\RegistrationType;
use App\Repository\CustomerRepository;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController {


    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response 
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/register", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
        $customer = new Customer();

        $customer->setCreatedAt(new \DateTime());
        $customer->setUpdatedAt(new \DateTime());
        $customer->setRole('ROLE_USER');

        $form = $this->createForm(RegistrationType::class, $customer);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $checkEmail = $this->repository->findOneByEmail($customer->getEmail());

            if($checkEmail != null) {
                if($checkEmail['email'] === $customer->getEmail()){
                    $this->addFlash('danger', 'Cet email est déja enregistré, veuillez vous connecter.');
                    return $this->render('security/register.html.twig', [
                        'form' => $form->createView()
                    ]);
                }
            }

            $hash = $encoder->encodePassword($customer, $customer->getPassword());

            $customer->setPassword($hash);

            $manager->persist($customer);
            $manager->flush();

            $this->addFlash(
                'success', 'Votre compte à bien été crée. Vous pouvez désormais vous connecter.'
            );
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }


}