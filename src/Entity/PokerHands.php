<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PokerHandsRepository")
 */
class PokerHands
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json_array")
     */
    private $Player1HandCard = [];

    /**
     * @ORM\Column(type="json_array")
     */
    private $Player2HandCard = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PokerHandsFile", cascade={"persist", "remove"}, inversedBy="pokerHands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $PokerHandsFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer1HandCard(): ?array
    {
        return $this->Player1HandCard;
    }

    public function setPlayer1HandCard(array $Player1HandCard): self
    {
        $this->Player1HandCard = $Player1HandCard;

        return $this;
    }

    public function getPlayer2HandCard(): ?array
    {
        return $this->Player2HandCard;
    }

    public function setPlayer2HandCard(array $Player2HandCard): self
    {
        $this->Player2HandCard = $Player2HandCard;

        return $this;
    }

    public function getPokerHandsFile(): ?PokerHandsFile
    {
        return $this->PokerHandsFile;
    }

    public function setPokerHandsFile(?PokerHandsFile $PokerHandsFile): self
    {
        $this->PokerHandsFile = $PokerHandsFile;

        return $this;
    }
}
