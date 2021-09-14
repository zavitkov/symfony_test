<?php

namespace App\Entity;

use App\Repository\BookTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

/**
 * @ORM\Entity(repositoryClass=BookTranslationRepository::class)
 */
class BookTranslation implements \JsonSerializable, TranslationInterface
{
    use TranslationTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->translatable;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getBook()->getId(),
            'name' => $this->getName(),
            'author' => $this->getBook()->getAuthor(),
        ];
    }
}
