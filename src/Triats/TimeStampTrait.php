<?php

namespace App\Triats;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


trait TimeStampTrait
{
    #[ORM\Column(nullable: true)]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $updatedAt = null;
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    #[ORM\PrePersist()]
    public function onPrePersist(){

        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();


    }

    #[ORM\PreUpdate()]
    public function onPreUpdate(){
        $this->updatedAt=new \DateTime();


    }


}