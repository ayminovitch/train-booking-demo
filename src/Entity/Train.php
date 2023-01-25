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
use App\Repository\TrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PreUpdate;

#[ORM\Entity(repositoryClass: TrainRepository::class)]
#[HasLifecycleCallbacks]
class Train implements ReferenceCodeInterface
{
    use ReferenceCodeTrait;
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'train', targetEntity: TripHistory::class)]
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

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
            $tripHistory->setTrain($this);
        }

        return $this;
    }

    public function removeTripHistory(TripHistory $tripHistory): self
    {
        if ($this->tripHistories->removeElement($tripHistory)) {
            // set the owning side to null (unless already changed)
            if ($tripHistory->getTrain() === $this) {
                $tripHistory->setTrain(null);
            }
        }

        return $this;
    }

    #[PreUpdate]
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }

    public function __toString()
    {
        return $this->name;
    }
}
