<?php

namespace App\Controller;

use App\BLL\ImagenBLL;
use App\Entity\Imagen;
use App\Form\ImagenType;
use App\Repository\ImagenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/imagen')]
final class ImagenController extends AbstractController
{
    #[Route(name: 'sym_imagen_index', methods: ['GET'])]
    #[Route('/orden/{ordenacion}', name: 'sym_imagen_index_ordenado', methods: ['GET'])]
    public function index(Request $requestStack, ImagenBLL $imagenBLL, ImagenRepository $imagenRepository, string $ordenacion = null): Response
    {
        $imagenes = $imagenBLL->getImagenesConOrdenacion($ordenacion);

        /* if (!is_null($ordenacion)) { // Cuando se establece un tipo de ordenación específico
            $tipoOrdenacion = 'asc';
            // Por defecto si no se había guardado antes en la variable de sesión
            $session = $requestStack->getSession();
            // Abrir la sesión
            $imagenesOrdenacion = $session->get('imagenesOrdenacion');
            if (!is_null($imagenesOrdenacion)) { // Comprobamos si ya se había establecido un orden
                if ($imagenesOrdenacion['ordenacion'] === $ordenacion) // Por si se ha cambiado de campo a ordenar
                {
                    if ($imagenesOrdenacion['tipoOrdenacion'] === 'asc')
                        $tipoOrdenacion = 'desc';
                }
            }
            $session->set('imagenesOrdenacion', [
                // Se guarda la ordenación actual
                'ordenacion' => $ordenacion,
                'tipoOrdenacion' => $tipoOrdenacion
            ]);
        } else {
            // La primera vez que se entra se establece por defecto la ordenación por id ascendente
            $ordenacion = 'id';
            $tipoOrdenacion = 'asc';
        }
        $imagenes = $imagenRepository->findImagenesConCategoria($ordenacion, $tipoOrdenacion); */
        return $this->render('imagen/index.html.twig', [
            'imagens' => $imagenes
        ]);
    }

    #[Route('/busqueda', name: 'app_imagen_index_busqueda', methods: ['POST'])]
    public function busqueda(Request $request, ImagenRepository $imagenRepository): Response
    {
        $fechaInicial = $request->request->get('fechaInicial');
        $fechaFinal = $request->request->get('fechaFinal');
        $busqueda = $request->request->get('busqueda');
        $usuario = $this->getUser();
        $imagenes = $imagenRepository->findImagenes($busqueda, $fechaInicial, $fechaFinal, $usuario);
        return $this->render('imagen/index.html.twig', [
            'imagens' => $imagenes,
            'busqueda' => $busqueda,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ]);
    }

    #[Route('/new', name: 'sym_imagen_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $imagen = new Imagen();
        $form = $this->createForm(ImagenType::class, $imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file almacena el archivo subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['nombre']->getData();
            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_subidas'), $fileName);
            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $imagen->setNombre($fileName);
            //Actualizamos el id del usuario que añade la imagen
            $usuario = $this->getUser();
            $imagen->setUsuario($usuario);
            $entityManager->persist($imagen);
            $entityManager->flush();

            $this->addFlash('mensaje', 'Se ha creado la imagen ' . $imagen->getNombre());

            return $this->redirectToRoute('sym_imagen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('imagen/new.html.twig', [
            'imagen' => $imagen,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'sym_imagen_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Imagen $imagen, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImagenType::class, $imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('sym_imagen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('imagen/edit.html.twig', [
            'imagen' => $imagen,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'sym_imagen_show', methods: ['GET'])]
    public function show(Imagen $imagen): Response
    {
        return $this->render('imagen/show.html.twig', [
            'imagen' => $imagen,
        ]);
    }

    #[Route('/{id}', name: 'sym_imagen_delete', methods: ['POST'])]
    public function delete(Request $request, Imagen $imagen, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete' . $imagen->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($imagen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sym_imagen_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_imagen_delete_json', methods: ['DELETE'])]
    public function deleteJson(Imagen $imagen, ImagenRepository $imagenRepository): Response
    {
        $imagenRepository->remove($imagen, true);
        return new JsonResponse(['eliminado' => true]);
    }
}
