<?php
namespace Mark\Models;

/**
 * Class News
 * 
 * Represents a news article in the system.
 * 
 * @package Mark\Class
 */
class News
{
    /**
     * @var int The ID of the news article
     */
    protected int $id;

    /**
     * @var string The title of the news article
     */
    protected string $title;

    /**
     * @var string The body content of the news article
     */
    protected string $body;

    /**
     * @var \DateTime The creation date and time of the news article
     */
    protected \DateTime $createdAt;

    /**
     * Set the ID of the news article.
     *
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the ID of the news article.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the title of the news article.
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the title of the news article.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the body content of the news article.
     *
     * @param string $body
     * @return self
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the body content of the news article.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Set the creation date and time of the news article.
     *
     * @param \DateTime $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the creation date and time of the news article.
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
