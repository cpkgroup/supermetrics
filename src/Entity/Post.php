<?php

namespace App\Entity;

use DateTime;

/**
 * TODO: remove id, type, message and add messageLen
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

    /**
     * @return int
     */
    public function getMessageLength()
    {
        return strlen($this->getMessage());
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return (int) str_replace('user_', '', $this->getFromId());
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->getCreatedTime()->format('Y-m');
    }

    /**
     * @return string
     */
    public function getWeek()
    {
        return $this->getCreatedTime()->format('Y-W');
    }
}
