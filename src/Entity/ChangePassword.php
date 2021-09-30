<?php

namespace App\Entity;

use App\Repository\ChangePasswordRepository;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChangePasswordRepository::class)
 */
class ChangePassword
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
    protected $oldPassword;

    protected $password;


    function getOldPassword()
    {
        return $this->oldPassword;
    }

    function getPassword()
    {
        return $this->password;
    }

    function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
}
