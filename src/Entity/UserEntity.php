<?php

namespace App\Entity;

use App\Repository\UserEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserEntityRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username.')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email address.')]
class UserEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $old_sys_id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Username is required.')]
    #[Assert\Length(min: 3, max: 180, minMessage: 'Username must be at least {{ limit }} characters long.')]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var list<string> The allowed roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles_allowed = [];

    /**
     * @var list<string> The types
     */
    #[ORM\Column(type: 'json')]
    private array $types = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'First name is required.')]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Last name is required.')]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $full_name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'Email is required.')]
    #[Assert\Email(message: 'Please enter a valid email address.')]
    private ?string $email = null;

    #[ORM\Column(type: 'boolean')]
    private bool $is_active = true;

    #[ORM\Column(type: 'boolean')]
    private bool $is_access_all_company = false;

    #[ORM\Column(type: 'boolean')]
    private bool $is_access_all_branch = false;

    #[ORM\Column(type: 'boolean')]
    private bool $is_access_all_b_u = false;

    #[ORM\Column(type: 'boolean')]
    private bool $is_access_all_division = false;

    #[ORM\Column(type: 'boolean')]
    private bool $is_access_all_dept = false;

    #[ORM\Column(type: 'boolean')]
    private bool $is_access_all_dept_unit = false;

    #[ORM\Column(type: 'boolean')]
    private bool $is_access_all_emp_type = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldSysId(): ?string
    {
        return $this->old_sys_id;
    }

    public function setOldSysId(?string $old_sys_id): static
    {
        $this->old_sys_id = $old_sys_id;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_values(array_unique($roles));
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return list<string>
     */
    public function getRolesAllowed(): array
    {
        return $this->roles_allowed;
    }

    /**
     * @param list<string> $roles_allowed
     */
    public function setRolesAllowed(array $roles_allowed): static
    {
        $this->roles_allowed = $roles_allowed;
        return $this;
    }

    /**
     * @return list<string>
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param list<string> $types
     */
    public function setTypes(array $types): static
    {
        $this->types = $types;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;
        $this->updateFullName();
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;
        $this->updateFullName();
        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(?string $full_name): static
    {
        $this->full_name = $full_name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;
        return $this;
    }

    public function isAccessAllCompany(): bool
    {
        return $this->is_access_all_company;
    }

    public function setIsAccessAllCompany(bool $is_access_all_company): static
    {
        $this->is_access_all_company = $is_access_all_company;
        return $this;
    }

    public function isAccessAllBranch(): bool
    {
        return $this->is_access_all_branch;
    }

    public function setIsAccessAllBranch(bool $is_access_all_branch): static
    {
        $this->is_access_all_branch = $is_access_all_branch;
        return $this;
    }

    public function isAccessAllBU(): bool
    {
        return $this->is_access_all_b_u;
    }

    public function setIsAccessAllBU(bool $is_access_all_b_u): static
    {
        $this->is_access_all_b_u = $is_access_all_b_u;
        return $this;
    }

    public function isAccessAllDivision(): bool
    {
        return $this->is_access_all_division;
    }

    public function setIsAccessAllDivision(bool $is_access_all_division): static
    {
        $this->is_access_all_division = $is_access_all_division;
        return $this;
    }

    public function isAccessAllDept(): bool
    {
        return $this->is_access_all_dept;
    }

    public function setIsAccessAllDept(bool $is_access_all_dept): static
    {
        $this->is_access_all_dept = $is_access_all_dept;
        return $this;
    }

    public function isAccessAllDeptUnit(): bool
    {
        return $this->is_access_all_dept_unit;
    }

    public function setIsAccessAllDeptUnit(bool $is_access_all_dept_unit): static
    {
        $this->is_access_all_dept_unit = $is_access_all_dept_unit;
        return $this;
    }

    public function isAccessAllEmpType(): bool
    {
        return $this->is_access_all_emp_type;
    }

    public function setIsAccessAllEmpType(bool $is_access_all_emp_type): static
    {
        $this->is_access_all_emp_type = $is_access_all_emp_type;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateFullName(): void
    {
        $this->full_name = trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }
}
