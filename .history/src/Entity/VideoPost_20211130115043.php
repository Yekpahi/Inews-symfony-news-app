<?php

namespace App\Entity;

use App\Repository\VideoPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=VideoPostRepository::class)
 * @ORM\Table(name="videoPost", indexes={@ORM\Index(columns={"title", "content", "description"}, flags={"fulltext"})})
 * @Vich\Uploadable
 */

class VideoPost
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @var string|null
     */
    private $videoPics;

    /**
     * @Vich\UploadableField(mapping="video_pics", fileNameProperty="videoPics")
     * @var File|null
     */
    private $videoPicsFile;

    /**

     * @ORM\Column(type="string")
     */
    private $videoFilename;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     *  @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="videoPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="videoPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;


    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="videoPosts", orphanRemoval=true)
     */
    private $comments;
     /**
     * @var string $nbVue
     *
     * @ORM\Column(name="nbVue", type="integer", length=100)
     */
    private $nbVue;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }


    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setVideoPosts($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getVideoPosts() === $this) {
                $comment->setVideoPosts(null);
            }
        }

        return $this;
    }

    public function setVideoPicsFile(File $videoPics = null)
    {
        $this->videoPicsFile = $videoPics;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($videoPics) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getVideoPicsFile(): ?File
    {
        return $this->videoPicsFile;
    }

    /**
     *
     * @param File|UploadedFile $image
     */
    public function setVideoPics($videoPics)
    {
        $this->videoPics = $videoPics;
        return $this->videoPics;
    }

    public function getVideoPics()
    {
        return $this->videoPics;
    }

    public function getVideoFilename()
    {
        return $this->videoFilename;
    }

    public function setVideoFilename($videoFilename)
    {
        $this->videoFilename = $videoFilename;

        return $this;
    }

    public function getNbVue() {
        return $this->nbVue;
    }
 
    public function setNbVue($nbVue) {
        $this->nbVue = $nbVue;
    }
}
