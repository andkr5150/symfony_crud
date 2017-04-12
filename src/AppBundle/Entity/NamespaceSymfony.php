<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * NamespaceSymfony
 *
 * @ORM\Entity
 */
class NamespaceSymfony
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=200)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="InterfaceSymfony", mappedBy="namespace")
     */
    private $interfaces;

    /**
     * NamespaceSymfony constructor.
     */
    public function __construct()
    {
        $this->interfaces = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getInterfaces(): ArrayCollection
    {
        return $this->interfaces;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return NamespaceSymfony
     */
    public function setName(string $name): NamespaceSymfony
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return NamespaceSymfony
     */
    public function setUrl(string $url): NamespaceSymfony
    {
        $this->url = $url;

        return $this;
    }
}