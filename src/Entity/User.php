<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @Vich\Uploadable
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];



    /**
     * @var string The hashed password
     * @Assert\Regex ("/^(?=\S*?[a-zA-Z])(?=\S*?[0-9]).{5,}\S/")
     * @ORM\Column(type="string")
     * @Assert\Length(max=4096, min="8", minMessage ="Votre mot de passe doit faire au minimum 8 caractères")
     * @Assert\EqualTo(propertyPath="confirm_password", message ="Vous n'avez pas tapé le même mot de passe")
     */
    private $password;

    /**
     * @Assert\Length(max=4096)
     *  @Assert\EqualTo(propertyPath="password", message ="Vous n'avez pas tapé le même mot de passe")
     */
    private $confirm_password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Articles::class, mappedBy="users", orphanRemoval=true)
     */
    private $articles;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\ManyToMany(targetEntity=Articles::class, mappedBy="favoris")
     */
    private $favoris;



    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="user", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=ArticleLikes::class, mappedBy="user", orphanRemoval=true)
     */
    private $likes;


    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $avatar;

    /**
     * @Vich\UploadableField(mapping="profile_avatar", fileNameProperty="avatar")
     * @var File|null
     */
    private $avatarFile;

    /**
     * @ORM\OneToMany(targetEntity=Laune::class, mappedBy="users", orphanRemoval=true)
     */
    private $launes;

    public function __toString()
    {
        return $this->lastName . $this->firstName;
    }

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->updatedAt = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->launes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $password): self
    {
        $this->confirm_password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

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
            $article->setUsers($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getUsers() === $this) {
                $article->setUsers(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }



    /**
     * @return Collection|Articles[]
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Articles $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris[] = $favori;
            $favori->addFavori($this);
        }

        return $this;
    }

    public function removeFavori(Articles $favori): self
    {
        if ($this->favoris->contains($favori)) {
            $this->favoris->removeElement($favori);
            $favori->removeFavori($this);
        }

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArticleLikes[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(ArticleLikes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(ArticleLikes $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }


    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function setAvatarFile(File $avatar = null)
    {
        $this->avatarFile = $avatar;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($avatar) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    /**
     *
     * @param File|UploadedFile $image
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this->avatar;
    }

    public function getAvatar()
    {
        return $this->avatar;
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
            $laune->setUsers($this);
        }

        return $this;
    }

    public function removeLaune(Laune $laune): self
    {
        if ($this->launes->removeElement($laune)) {
            // set the owning side to null (unless already changed)
            if ($laune->getUsers() === $this) {
                $laune->setUsers(null);
            }
        }

        return $this;
    }
}
