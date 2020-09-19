<?php

namespace App\Entity;

use DateTime;

/**
 * TODO: remove id, type, message and add messageLen
 * Class Post
 * @package App\Entity
 */
class Post
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $fromName;

    /**
     * @var string
     */
    private string $fromId;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var DateTime
     */
    private DateTime $createdTime;

    /**
     * Post constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst(str_replace([' ', '_'], '', ucwords(strtolower($key), ' _')));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Post
     */
    public function setId(string $id): Post
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     * @return Post
     */
    public function setFromName(string $fromName): Post
    {
        $this->fromName = $fromName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFromId(): string
    {
        return $this->fromId;
    }

    /**
     * @param string $fromId
     * @return Post
     */
    public function setFromId(string $fromId): Post
    {
        $this->fromId = $fromId;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Post
     */
    public function setMessage(string $message): Post
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Post
     */
    public function setType(string $type): Post
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedTime(): DateTime
    {
        return $this->createdTime;
    }

    /**
     * @param string $createdTime
     * @return Post
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
        return (int)str_replace('user_', '', $this->getFromId());
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
