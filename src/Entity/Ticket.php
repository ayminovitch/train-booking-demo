<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Mon Jan 16 2023
 */

namespace App\Entity;

use App\Entity\Traits\ReferenceCodeTrait;
use App\Entity\Traits\Timestampable;
use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PreUpdate;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[HasLifecycleCallbacks]
class Ticket implements ReferenceCodeInterface
{
    use ReferenceCodeTrait;
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?User $user = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Station $destination_from = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Station $destination_to = null;

    #[ORM\OneToMany(mappedBy: 'ticket', targetEntity: TripHistory::class)]
    private Collection $tripHistories;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->tripHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDestinationFrom(): ?Station
    {
        return $this->destination_from;
    }

    public function setDestinationFrom(?Station $destination_from): self
    {
        $this->destination_from = $destination_from;

        return $this;
    }

    public function getDestinationTo(): ?Station
    {
        return $this->destination_to;
    }

    public function setDestinationTo(?Station $destination_to): self
    {
        $this->destination_to = $destination_to;

        return $this;
    }

    /**
     * @return Collection<int, TripHistory>
     */
    public function getTripHistories(): Collection
    {
        return $this->tripHistories;
    }

    public function addTripHistory(TripHistory $tripHistory): self
    {
        if (!$this->tripHistories->contains($tripHistory)) {
            $this->tripHistories->add($tripHistory);
            $tripHistory->setTicket($this);
        }

        return $this;
    }

    public function removeTripHistory(TripHistory $tripHistory): self
    {
        if ($this->tripHistories->removeElement($tripHistory)) {
            // set the owning side to null (unless already changed)
            if ($tripHistory->getTicket() === $this) {
                $tripHistory->setTicket(null);
            }
        }

        return $this;
    }

    #[PreUpdate]
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }
}
