<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Mon Jan 16 2023
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class SecurityController extends AbstractController
{
    use TargetPathTrait;

    #[Route('/login', name: 'security_login')]
    public function login(Request $request, AuthenticationUtils $helper): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('security_login');
        }

        $this->saveTargetPath($request->getSession(), 'main', $this->generateUrl('easyadmin'));

        return $this->render('security/login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
        ]);
    }

    #[Route('/logout', name: 'security_logout')]
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
