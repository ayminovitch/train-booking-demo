<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Wed Jan 18 2023
 */

namespace App\Entity;

use App\Entity\Traits\ReferenceCodeTrait;
use App\Entity\Traits\Timestampable;
use App\Repository\TripHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripHistoryRepository::class)]
class TripHistory implements ReferenceCodeInterface
{
    use ReferenceCodeTrait;
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tripHistories')]
    private ?Trip $trip = null;

    #[ORM\ManyToOne(inversedBy: 'tripHistories')]
    private ?Train $train = null;

    #[ORM\ManyToOne(inversedBy: 'tripHistories')]
    private ?User $conductor = null;

    #[ORM\ManyToOne(inversedBy: 'tripHistories')]
    private ?Ticket $ticket = null;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrip(): ?Trip
    {
        return $this->trip;
    }

    public function setTrip(?Trip $trip): self
    {
        $this->trip = $trip;

        return $this;
    }

    public function getTrain(): ?Train
    {
        return $this->train;
    }

    public function setTrain(?Train $train): self
    {
        $this->train = $train;

        return $this;
    }

    public function getConductor(): ?User
    {
        return $this->conductor;
    }

    public function setConductor(?User $conductor): self
    {
        $this->conductor = $conductor;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}
