<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event extends AbstractEntity
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank(message="field.not_blank")
	 *
	 */
	private $title;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $content;

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
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 *
	 * @return Event
	 */
	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getContent(): ?string
	{
		return $this->content;
	}

	/**
	 * @param string $content
	 *
	 * @return Event
	 */
	public function setContent(string $content): self
	{
		$this->content = $content;

		return $this;
	}
}
