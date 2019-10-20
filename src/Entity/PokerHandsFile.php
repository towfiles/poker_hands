<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PokerHandsFileRepository")
 */
class PokerHandsFile
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
    private $fileName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PokerHands", mappedBy="PokerHandsFile",  cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $pokerHands;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    public function __construct()
    {
        $this->pokerHands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }


    /**
     * @return Collection|PokerHands[]
     */
    public function getPokerHands(): Collection
    {
        return $this->pokerHands;
    }

    public function addPokerHand(PokerHands $pokerHand): self
    {
        if (!$this->pokerHands->contains($pokerHand)) {
            $this->pokerHands[] = $pokerHand;
            $pokerHand->setPokerHandsFile($this);
        }

        return $this;
    }

    public function removePokerHand(PokerHands $pokerHand): self
    {
        if ($this->pokerHands->contains($pokerHand)) {
            $this->pokerHands->removeElement($pokerHand);
            // set the owning side to null (unless already changed)
            if ($pokerHand->getPokerHandsFile() === $this) {
                $pokerHand->setPokerHandsFile(null);
            }
        }

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
