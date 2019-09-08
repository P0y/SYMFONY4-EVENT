<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="email.not_unique"
 * )
 */
class User extends AbstractEntity
{
	const COST_ENCODE = 12;
	const SALT = 'mZ$YTN#McCVTTrqk@dnxm5aZRNT%(w4DVJuKx!oK';

	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=70)
	 * @Assert\NotBlank(message="field.not_blank")
	 */
	private $firstName;

	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank(message="field.not_blank")
	 */
	private $lastName;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Email(
	 *     message = "email.not_valid",
	 *     checkMX = true,
	 *     checkHost = true
	 * )
	 */
	private $email;

	/**
	 * @Assert\Length(
	 *      min = 6,
	 *      max = 12,
	 *      minMessage = "field.not_long_enough",
	 *      maxMessage = "field.not_too_long"
	 * )
	 */
	private $password;

	/**
	 * @ORM\Column(name="password", type="string", length=255)
	 */
	private $passwordEncode;

	/**
	 * @return int|null
	 */
	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * @return null|string
	 */
	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 *
	 * @return User
	 */
	public function setFirstName(string $firstName): self
	{
		$this->firstName = $firstName;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getLastName(): ?string
	{
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 *
	 * @return User
	 */
	public function setLastName(string $lastName): self
	{
		$this->lastName = $lastName;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 *
	 * @return User
	 */
	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getPassword(): ?string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 *
	 * @return User
	 */
	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPasswordEncode()
	{
		return $this->passwordEncode;
	}

	/**
	 * @param mixed $passwordEncode
	 *
	 * @return User
	 */
	public function setPasswordEncode($passwordEncode)
	{
		$this->passwordEncode = $this->encodePassword($passwordEncode);

		return $this;
	}

	/**
	 * @return array
	 */
	public function serializer(): array
	{
		$data = parent::serializer();
		unset($data['password']);

		return $data;
	}

	/**
	 * @param string $plainPassword
	 *
	 * @return string
	 */
	public function encodePassword(string $plainPassword): string
	{
		$encoder = new BCryptPasswordEncoder(self::COST_ENCODE);
		$passwordEncode = $encoder->encodePassword($plainPassword, self::SALT);

		return $passwordEncode;
	}

	/**
	 * @param string $password
	 * @param string $passwordEncoded
	 *
	 * @return bool
	 */
	public function isPasswordValid(string $password, string $passwordEncoded): bool
	{
		$encoder = new BCryptPasswordEncoder(self::COST_ENCODE);
		$test = $encoder->isPasswordValid($passwordEncoded, $password, self::SALT);

		return $test;
	}
}
