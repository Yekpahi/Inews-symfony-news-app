<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="categories")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Categories::class, mappedBy="parent")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Articles::class, mappedBy="categories")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity=Laune::class, mappedBy="categories", orphanRemoval=true)
     */
    private $launes;

    /**
     * @ORM\OneToMany(targetEntity=VideoPost::class, mappedBy="categories", orphanRemoval=true)
     */
    private $videoPosts;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->launes = new ArrayCollection();
        $this->videoPosts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }


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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setParent($this);
        }

        return $this;
    }

    public function removeCategory(self $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getParent() === $this) {
                $category->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategories($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategories() === $this) {
                $article->setCategories(null);
            }
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Laune[]
     */
    public function getLaunes(): Collection
    {
        return $this->launes;
    }

    public function addLaune(Laune $laune): self
    {
        if (!$this->launes->contains($laune)) {
            $this->launes[] = $laune;
            $laune->setCategories($this);
        }

        return $this;
    }

    public function removeLaune(Laune $laune): self
    {
        if ($this->launes->removeElement($laune)) {
            // set the owning side to null (unless already changed)
            if ($laune->getCategories() === $this) {
                $laune->setCategories(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VideoPost[]
     */
    public function getVideoPosts(): Collection
    {
        return $this->videoPosts;
    }

    public function addVideoPost(VideoPost $videoPost): self
    {
        if (!$this->videoPosts->contains($videoPost)) {
            $this->videoPosts[] = $videoPost;
            $videoPost->setCategories($this);
        }

        return $this;
    }

    public function removeVideoPost(VideoPost $videoPost): self
    {
        if ($this->videoPosts->removeElement($videoPost)) {
            // set the owning side to null (unless already changed)
            if ($videoPost->getCategories() === $this) {
                $videoPost->setCategories(null);
            }
        }

        return $this;
    }
}
