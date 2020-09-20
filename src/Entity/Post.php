<?php

namespace App\Entity;

use DateTime;

/**
 * Class Post.
 */
class Post
{
    private string $id;

    private string $fromName;

    private string $fromId;

    private string $message;

    private string $type;

    private DateTime $createdTime;

    /**
     * Post constructor.
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * This method apply array data to this object.
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst(str_replace([' ', '_'], '', ucwords(strtolower($key), ' _')));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Post
    {
        $this->id = $id;

        return $this;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function setFromName(string $fromName): Post
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getFromId(): string
    {
        return $this->fromId;
    }

    public function setFromId(string $fromId): Post
    {
        $this->fromId = $fromId;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Post
    {
        $this->message = $message;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Post
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedTime(): DateTime
    {
        return $this->createdTime;
    }

    /**
     * @throws \Exception
     */
    public function setCreatedTime(string $createdTime): Post
    {
        $this->createdTime = new DateTime($createdTime);

        return $this;
    }

    public function getMessageLength(): int
    {
        return strlen($this->getMessage());
    }

    public function getUserId(): int
    {
        return (int) str_replace('user_', '', $this->getFromId());
    }

    public function getMonth(): string
    {
        return $this->getCreatedTime()->format('Y-m');
    }

    public function getWeek(): string
    {
        return $this->getCreatedTime()->format('Y-W');
    }
}
