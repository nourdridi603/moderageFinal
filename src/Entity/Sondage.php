<?php

namespace App\Entity;

use App\Repository\SondageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SondageRepository::class)
 */
class Sondage
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
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbParticiapants;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbQuestion;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sondages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enqueteur;

    /**
     * @ORM\ManyToOne(targetEntity=Sujet::class, inversedBy="sondages")
     */
    private $sujet;

    /**
     * @ORM\OneToMany(targetEntity=QuestionLogique::class, mappedBy="sondage")
     */
    private $questionLogiques;

    /**
     * @ORM\OneToMany(targetEntity=QuestionChoixMultiples::class, mappedBy="sondage")
     */
    private $questionChoixMultiples;

    public function __construct()
    {
        $this->questionLogiques = new ArrayCollection();
        $this->questionChoixMultiples = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNbParticiapants(): ?int
    {
        return $this->nbParticiapants;
    }

    public function setNbParticiapants(int $nbParticiapants): self
    {
        $this->nbParticiapants = $nbParticiapants;

        return $this;
    }

    public function getNbQuestion(): ?int
    {
        return $this->nbQuestion;
    }

    public function setNbQuestion(int $nbQuestion): self
    {
        $this->nbQuestion = $nbQuestion;

        return $this;
    }

    public function getEnqueteur(): ?User
    {
        return $this->enqueteur;
    }

    public function setEnqueteur(?User $enqueteur): self
    {
        $this->enqueteur = $enqueteur;

        return $this;
    }

    public function getSujet(): ?Sujet
    {
        return $this->sujet;
    }

    public function setSujet(?Sujet $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * @return Collection|QuestionLogique[]
     */
    public function getQuestionLogiques(): Collection
    {
        return $this->questionLogiques;
    }

    public function addQuestionLogique(QuestionLogique $questionLogique): self
    {
        if (!$this->questionLogiques->contains($questionLogique)) {
            $this->questionLogiques[] = $questionLogique;
            $questionLogique->setSondage($this);
        }

        return $this;
    }

    public function removeQuestionLogique(QuestionLogique $questionLogique): self
    {
        if ($this->questionLogiques->removeElement($questionLogique)) {
            // set the owning side to null (unless already changed)
            if ($questionLogique->getSondage() === $this) {
                $questionLogique->setSondage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|QuestionChoixMultiples[]
     */
    public function getQuestionChoixMultiples(): Collection
    {
        return $this->questionChoixMultiples;
    }

    public function addQuestionChoixMultiple(QuestionChoixMultiples $questionChoixMultiple): self
    {
        if (!$this->questionChoixMultiples->contains($questionChoixMultiple)) {
            $this->questionChoixMultiples[] = $questionChoixMultiple;
            $questionChoixMultiple->setSondage($this);
        }

        return $this;
    }

    public function removeQuestionChoixMultiple(QuestionChoixMultiples $questionChoixMultiple): self
    {
        if ($this->questionChoixMultiples->removeElement($questionChoixMultiple)) {
            // set the owning side to null (unless already changed)
            if ($questionChoixMultiple->getSondage() === $this) {
                $questionChoixMultiple->setSondage(null);
            }
        }

        return $this;
    }
}
