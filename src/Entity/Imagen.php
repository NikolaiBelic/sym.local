<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ImagenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagenRepository::class)]
class Imagen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    /**
     * @Assert\File(
     *mimeTypes={"image/jpeg","image/png"},
     *mimeTypesMessage = "Solamente se permiten archivos jpeg o png.")
     */
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?int $numVisualizaciones = null;

    #[ORM\Column]
    private ?int $numLikes = null;

    #[ORM\Column]
    private ?int $numDownloads = null;

    #[ORM\Column(length: 100)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'imagens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoria $categoria = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha = null;

    const RUTA_IMAGENES_PORTFOLIO = 'images/index/portfolio/';
    const RUTA_IMAGENES_GALERIA = 'images/index/gallery/';
    const RUTA_IMAGENES_LOGOS = 'images/logos/';
    const RUTA_IMAGENES_CLIENTES = 'images/clients/';
    const RUTA_IMAGENES_SUBIDAS = 'images/galeria/';

    function __construct($nombre = "", $descripcion = "", $categoria = 0, $numVisualizaciones = 0, $numLikes = 0, $numDownloads = 0, $password = "")
    {
        $this->id = null;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        /* $this->categoria = $categoria; */
        $this->numVisualizaciones = $numVisualizaciones;
        $this->numLikes = $numLikes;
        $this->numDownloads = $numDownloads;
        $this->password = $password;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getNumVisualizaciones(): ?int
    {
        return $this->numVisualizaciones;
    }

    public function setNumVisualizaciones(int $numVisualizaciones): static
    {
        $this->numVisualizaciones = $numVisualizaciones;

        return $this;
    }

    public function getNumLikes(): ?int
    {
        return $this->numLikes;
    }

    public function setNumLikes(int $numLikes): static
    {
        $this->numLikes = $numLikes;

        return $this;
    }

    public function getNumDownloads(): ?int
    {
        return $this->numDownloads;
    }

    public function setNumDownloads(int $numDownloads): static
    {
        $this->numDownloads = $numDownloads;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getUrlPortfolio()
    {
        return self::RUTA_IMAGENES_PORTFOLIO . $this->getNombre();
    }

    public function getUrlGaleria()
    {
        return self::RUTA_IMAGENES_GALERIA . $this->getNombre();
    }

    public function getUrlClientes()
    {
        return self::RUTA_IMAGENES_CLIENTES . $this->getNombre();
    }

    public function getUrlSubidas()
    {
        return self::RUTA_IMAGENES_SUBIDAS . $this->getNombre();
    }

    public function getUrlLogos()
    {
        return self::RUTA_IMAGENES_LOGOS . $this->getNombre();
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }
}
