<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     */
    protected $roles;

    /**
     * @ORM\Column(type="string")
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string")
     */
    protected $phone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="employees")
     */
    protected $department;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="client")
     */
    protected $order;

//    /**
//     * @ORM\Column(type="string", nullable=true)
//     */
//    protected $lat;
//
//    /**
//     * @ORM\Column(type="string", nullable=true)
//     */
//    protected $lng;


    public function __construct()
    {
        $this->isActive = true;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        $roles[] = $this->roles;
        return $roles;
    }

    public function getRole()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function setLastLogin(): void
    {
        $this->lastLogin = new \DateTime();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment($department): void
    {
        $this->department = $department;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }

//    /**
//     * @return mixed
//     */
//    public function getAddress()
//    {
//        return $this->address;
//    }
//
//    /**
//     * @param mixed $address
//     */
//    public function setAddress($address): void
//    {
//        $this->address = $address;
//    }

    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getFullInfo()
    {
        $role = $this->getRole();
        switch ($role){
            case 'ROLE_ADMIN':
                $role = 'Администратор';
                break;

            case 'ROLE_MANAGER':
                $role = 'Менеджер';
                break;

            case 'ROLE_MASTER':
                $role = 'Мастер';
                break;

            case 'ROLE_COURIER':
                $role = 'Курьер';
                break;
            case 'ROLE_CLIENT':
                $role = 'Клиент';
                break;
        }
        return $this->getFirstName() . ' ' . $this->getLastName() . ' (' . $role . ', ' . $this->getDepartment()->getAddress() . ')';
    }
}