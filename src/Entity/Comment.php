<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $author = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\ManyToOne(targetEntity: Blog::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Blog $blog = null;

    /**
     * Comment constructor.
     * Initializes the creation date to the current time adjusted by +2 hours.
     */
    public function __construct()
    {
        $this->createdAt = (new \DateTime())->modify('+2 hours');
    }

    /**
     * Get the ID of the comment.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the content of the comment.
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the content of the comment.
     *
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get the creation date of the comment.
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set the creation date of the comment.
     *
     * @param \DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get the author of the comment.
     *
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * Set the author of the comment.
     *
     * @param string $author
     * @return $this
     */
    public function setAuthor(string $author): static
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get the email of the author of the comment.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the email of the author of the comment.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the blog associated with the comment.
     *
     * @return Blog|null
     */
    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    /**
     * Set the blog associated with the comment.
     *
     * @param Blog|null $blog
     * @return $this
     */
    public function setBlog(?Blog $blog): static
    {
        $this->blog = $blog;
        return $this;
    }
}
