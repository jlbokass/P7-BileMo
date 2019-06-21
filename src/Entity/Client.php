<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @UniqueEntity(fields={"email"}, message="This email already exists")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
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
}
