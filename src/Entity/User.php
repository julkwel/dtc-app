<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, Serializable, EquatableInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    public const ROLE_STUDENT = 'ROLE_STUDENT';
    public const ROLE_TRAINER = 'ROLE_TRAINER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const ROLES = [
        self::ROLE_STUDENT => self::ROLE_STUDENT,
        self::ROLE_TRAINER => self::ROLE_TRAINER,
        self::ROLE_ADMIN => self::ROLE_ADMIN,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $username = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $password = null;
    private ?string $salt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isEnabled = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: StudentFormation::class)]
    private Collection $studentFormations;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cover = null;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Contact $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string $phone = '';

    public function __construct()
    {
        $this->roles = [self::ROLE_STUDENT];
        $this->isEnabled = true;
        $this->studentFormations = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function isStudent(): bool
    {
        return in_array(self::ROLE_STUDENT, $this->getRoles());
    }

    public function isAdmin(): bool
    {
        return in_array(self::ROLE_ADMIN, $this->getRoles());
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     *
     * @return User
     */
    public function setFirstname(?string $firstname): User
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     *
     * @return User
     */
    public function setLastname(?string $lastname): User
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     *
     * @return User
     */
    public function setImage(?string $image): User
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     *
     * @return User
     */
    public function setUsername(?string $username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     *
     * @return User
     */
    public function setPassword(?string $password): User
    {
        $this->password = $password;

        return $this;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        $this->password = "";
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function serialize(): ?string
    {
        return serialize(array($this->id, $this->username, $this->password, $this->salt));
    }

    public function unserialize(?string $data)
    {
        list($this->id, $this->username, $this->password, $this->salt) = unserialize($data, array('allowed_classes' => false));
    }

    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($user->getId() == $this->getId()) {
            return true;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    public function isEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(?bool $isEnable): static
    {
        $this->isEnabled = $isEnable;

        return $this;
    }

    /**
     * @return Collection<int, StudentFormation>
     */
    public function getStudentFormations(): Collection
    {
        return $this->studentFormations;
    }

    public function addStudentFormation(StudentFormation $studentFormation): static
    {
        if (!$this->studentFormations->contains($studentFormation)) {
            $this->studentFormations->add($studentFormation);
            $studentFormation->setUser($this);
        }

        return $this;
    }

    public function removeStudentFormation(StudentFormation $studentFormation): static
    {
        if ($this->studentFormations->removeElement($studentFormation)) {
            // set the owning side to null (unless already changed)
            if ($studentFormation->getUser() === $this) {
                $studentFormation->setUser(null);
            }
        }

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        // unset the owning side of the relation if necessary
        if ($contact === null && $this->contact !== null) {
            $this->contact->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($contact !== null && $contact->getUser() !== $this) {
            $contact->setUser($this);
        }

        $this->contact = $contact;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
}
