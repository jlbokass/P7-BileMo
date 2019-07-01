<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation as Serializer;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 *
 * @UniqueEntity(fields={"email"}, message="This email already exists")
 *
 * @ExclusionPolicy("all")
 *
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *     "app_client_show",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "modify",
 *     href=@Hateoas\Route(
 *     "app_client_update",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "delete",
 *     href=@Hateoas\Route(
 *     "app_client_delete",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "user",
 *     embedded = @Hateoas\Embedded("expr(object.getUser())")
 * )
 *
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @Assert\NotBlank(message="Username cannot be blank")
     * @Assert\Length(
     *      min="6",
     *     max="12",
     *     minMessage="The username must be at least {{ limit }} characters long",
     *     maxMessage="The username cannot be longer than {{ limit }} characters"
     * )
     *
     * @Serializer\Expose
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @Assert\NotBlank(message="Email cannot be null")
     * @Assert\Email(
     *     message="The email '{{ value }}' is not a valid email"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message="The password cannot be null"
     * )
     * @Assert\Length(
     *     min="6",
     *     max="12",
     *     minMessage="The password must be at least {{ limit }} characters long",
     *     maxMessage="The password cannot be longer than {{ limit }} characters"
     * )
     *
     * @Assert\Regex(pattern="*[a-z]+.*",
     *     match=true,
     *     message="Password needs at least one letter")
     *
     * @Assert\Regex(pattern="*\d+.*",
     *     match=true,
     *     message="Password needs at least one number")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clients")
     *
     *
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
