<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Author::class, inversedBy="books")
     */
    private $author_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lang;

    public function __construct()
    {
        $this->author_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Author[]
     */
    public function getAuthorId(): Collection
    {
        return $this->author_id;
    }

    public function addAuthorId(Author $authorId): self
    {
        if (!$this->author_id->contains($authorId)) {
            $this->author_id[] = $authorId;
        }

        return $this;
    }

    public function removeAuthorId(Author $authorId): self
    {
        $this->author_id->removeElement($authorId);

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }
}
