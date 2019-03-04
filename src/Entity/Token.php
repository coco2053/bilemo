<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents the token enity.
 * @author Bastien Vacherand.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 */
class Token
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", mappedBy="token", cascade={"persist", "remove"})
     */
    private $client;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }

    public function checkValidity()
    {
        $now = new \DateTime("now");
        $interval = date_diff($this->getCreatedAt(), $now);
        if ($interval->format('%h') > 0) {
            return false;
        }
        return true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        // set the owning side of the relation if necessary
        if ($this !== $client->getToken()) {
            $client->setToken($this);
        }

        return $this;
    }
}
