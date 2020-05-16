<?php
namespace App\Controller\Auth;

use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends AbstractController
{
    // Login
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('/login.html.twig');
    }

    //******************** FINIR LE REGISTER **********************//

    // Register
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    
    /**
     * @Route("/register", name="register")
     * @param Request $request
     */
    public function index(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $user = $this->customerRepository->findOneBy([
            'email' => $email,
        ]);

        return $this->render('/register.html.twig');
    }

}