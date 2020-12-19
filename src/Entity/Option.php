<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $choix;

    /**
     * @ORM\ManyToOne(targetEntity=QuestionLogique::class, inversedBy="options")
     */
    private $QuestionLogique;

    /**
     * @ORM\ManyToOne(targetEntity=QuestionChoixMultiples::class, inversedBy="options")
     */
    private $questionChoixMultiples;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChoix(): ?string
    {
        return $this->choix;
    }

    public function setChoix(string $choix): self
    {
        $this->choix = $choix;

        return $this;
    }

    public function getQuestionLogique(): ?QuestionLogique
    {
        return $this->QuestionLogique;
    }

    public function setQuestionLogique(?QuestionLogique $QuestionLogique): self
    {
        $this->QuestionLogique = $QuestionLogique;

        return $this;
    }

    public function getQuestionChoixMultiples(): ?QuestionChoixMultiples
    {
        return $this->questionChoixMultiples;
    }

    public function setQuestionChoixMultiples(?QuestionChoixMultiples $questionChoixMultiples): self
    {
        $this->questionChoixMultiples = $questionChoixMultiples;

        return $this;
    }
}
