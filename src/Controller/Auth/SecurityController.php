<?php
namespace App\Controller\Auth;

use App\Entity\Customer;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController {

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils) {
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
            $hash = $encoder->encodePassword($customer, $customer->getPassword());

            $customer->setPassword($hash);

            $manager->persist($customer);
            $manager->flush();
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }


}