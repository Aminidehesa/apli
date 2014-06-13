<?php

namespace Cupon\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Cupon\UsuarioBundle\Entity\Usuario;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioType;


class DefaultController extends Controller
{
    public function comprasAction()
    {
        $usuario_id = 5;
        
        $em = $this->getDoctrine()->getManager();
        $compras = $em->getRepository('UsuarioBundle:Usuario')
                    ->findTodasLasCompras($usuario_id);
        return $this->render('UsuarioBundle:Default:compras.html.twig', array(
        'compras' => $compras
        ));
    }
    public function loginAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        
        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );
        
        return $this->render('UsuarioBundle:Default:login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }
    public function cajaLoginAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        
        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );
        
        return $this->render('UsuarioBundle:Default:cajaLogin.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }
//    public function defaultAction()
//    {
//        $usuario = new Usuario();
//        
//        $encoder = $this->get('security.encoder_factory')
//                    ->getEncoder($usuario);
//        
//        $password = $encoder->encodePassword('usuario1',
//                    $usuario->getSalt()
//        );
//        $usuario->setPassword($password);
//    }
    public function registroAction()
    {
        $usuario = new Usuario();
        $usuario->setPermiteEmail(true);
//        $usuario->setFechaNacimiento(new \DateTime('today - 18 years'));
        
        $formulario = $this->createForm(new UsuarioType(), $usuario);
        
        return $this->render('UsuarioBundle:Default:registro.html.twig',
            array('formulario' => $formulario->createView())
        );
    }

}
