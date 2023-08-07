<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;
    
    #[Assert\NotBlank]
    #[Assert\Length(
        min:2,
        max:50,
        minMessage : "Minimum 2 caractères",
        maxMessage: "Maximum 50 caractères"
    )]
    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min:2,
        max:50,
        minMessage : "Minimum 2 caractères",
        maxMessage: "Maximum 50 caractères"
    )]
    
    #[Assert\NotBlank]
    #[Assert\Length(
        min:2,
        max:50,
        minMessage : "Minimum 2 caractères",
        maxMessage: "Maximum 50 caractères"
    )]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $nbBooks = null;

    #[ORM\Column]
    private ?int $nbBorrowedBooks = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNbBooks(): ?int
    {
        return $this->nbBooks;
    }

    public function setNbBooks(int $nbBooks): static
    {
        $this->nbBooks = $nbBooks;

        return $this;
    }

    public function getNbBorrowedBooks(): ?int
    {
        return $this->nbBorrowedBooks;
    }

    public function setNbBorrowedBooks(int $nbBorrowedBooks): static
    {
        $this->nbBorrowedBooks = $nbBorrowedBooks;

        return $this;
    }
}
