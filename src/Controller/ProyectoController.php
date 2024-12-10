<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Imagen;

class ProyectoController extends AbstractController
{
    #[Route('/', name: 'sym_index')]
    public function index()
    {
        $imagenesHome[] = new Imagen('1.jpg', 'descripción imagen 1', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('2.jpg', 'descripción imagen 2', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('3.jpg', 'descripción imagen 3', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('4.jpg', 'descripción imagen 4', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('5.jpg', 'descripción imagen 5', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('6.jpg', 'descripción imagen 6', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('7.jpg', 'descripción imagen 7', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('8.jpg', 'descripción imagen 8', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('9.jpg', 'descripción imagen 9', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('10.jpg', 'descripción imagen 10', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('11.jpg', 'descripción imagen 11', 1, 46, 61, 135);
        $imagenesHome[] = new Imagen('12.jpg', 'descripción imagen 12', 1, 456, 610, 130);

        $imagenesLogo[] = new Imagen('log1.jpg', 'descripción logo 1');
        $imagenesLogo[] = new Imagen('log2.jpg', 'descripción logo 2');
        $imagenesLogo[] = new Imagen('log3.jpg', 'descripción logo 3');

        return $this->render('index.view.html.twig', [
            'imagenes' => $imagenesHome,
            'logos' => $imagenesLogo
        ]);
    }

    #[Route('/about', name: 'sym_about')]
    public function about() {
        $imagenesClientes[] = new Imagen('client1.jpg', 'Miss Flower');
        $imagenesClientes[] = new Imagen('client2.jpg', 'Don Peno');
        $imagenesClientes[] = new Imagen('client3.jpg', 'Sweety');
        $imagenesClientes[] = new Imagen('client4.jpg', 'Lady');

        return $this->render('about.view.html.twig', [
            'imagenes' => $imagenesClientes
        ]);
    }

    #[Route('/contact', name: 'sym_contact')]
    public function contact() {
        return $this->render('contact.view.html.twig');
    }

    #[Route('/blog', name: 'sym_blog')]
    public function blog() {
        return $this->render('blog.view.html.twig');
    }

    #[Route('/galeria', name: 'sym_galeria')]
    public function galeria() {
        return $this->render('galeria.view.html.twig');
    }
}
