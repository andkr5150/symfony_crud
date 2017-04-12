<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassSymfony
 *
 * @ORM\Entity
 */
class ClassSymfony
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
     * @ORM\ManyToOne(targetEntity="NamespaceSymfony", inversedBy="interfaces")
     */
    private $namespace;

    /**
     * @return mixed
     */
    public function getNamespace(): NamespaceSymfony
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     *
     * @return ClassSymfony
     */
    public function setNamespace(NamespaceSymfony $namespace): ClassSymfony
    {
        $this->namespace = $namespace;

        return $this;
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
     * @return ClassSymfony
     */
    public function setName(string $name): ClassSymfony
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
     * @return ClassSymfony
     */
    public function setUrl(string $url): ClassSymfony
    {
        $this->url = $url;

        return $this;
    }
}