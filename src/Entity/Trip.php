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
use App\Repository\TripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PreUpdate;

#[ORM\Entity(repositoryClass: TripRepository::class)]
#[HasLifecycleCallbacks]
class Trip implements ReferenceCodeInterface
{
    use ReferenceCodeTrait;
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    private ?Station $stationFrom = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    private ?Station $stationTo = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $arrivalTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $departureTime = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'trip', targetEntity: TripHistory::class)]
    private Collection $tripHistories;

    public function __construct()
    {
        $this->tripHistories = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStationFrom(): ?Station
    {
        return $this->stationFrom;
    }

    public function setStationFrom(?Station $stationFrom): self
    {
        $this->stationFrom = $stationFrom;

        return $this;
    }

    public function getStationTo(): ?Station
    {
        return $this->stationTo;
    }

    public function setStationTo(?Station $stationTo): self
    {
        $this->stationTo = $stationTo;

        return $this;
    }

    public function getArrivalTime(): ?\DateTimeInterface
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(?\DateTimeInterface $arrivalTime): self
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    public function getDepartureTime(): ?\DateTimeInterface
    {
        return $this->departureTime;
    }

    public function setDepartureTime(?\DateTimeInterface $departureTime): self
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $tripHistory->setTrip($this);
        }

        return $this;
    }

    public function removeTripHistory(TripHistory $tripHistory): self
    {
        if ($this->tripHistories->removeElement($tripHistory)) {
            // set the owning side to null (unless already changed)
            if ($tripHistory->getTrip() === $this) {
                $tripHistory->setTrip(null);
            }
        }

        return $this;
    }

    #[PreUpdate]
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }

    public function __toString(): string
    {
        return $this->getStationFrom()->getName() . ' - ' . $this->getStationTo()->getName();
    }
}
