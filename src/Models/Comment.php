<?php
namespace Mark\Models;

/**
 * Class Comment
 * 
 * Represents a comment in the system.
 * 
 * @package Mark\Class
 */
class Comment
{
    /**
     * @var int The ID of the comment
     */
    protected int $id;

    /**
     * @var string The body of the comment
     */
    protected string $body;

    /**
     * @var \DateTime The creation date and time of the comment
     */
    protected \DateTime $createdAt;

    /**
     * @var int The ID of the related news item
     */
    protected int $newsId;

    /**
     * Set the ID of the comment.
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
     * Get the ID of the comment.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the body of the comment.
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
     * Get the body of the comment.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Set the creation date and time of the comment.
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
     * Get the creation date and time of the comment.
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the ID of the related news item.
     *
     * @param int $newsId
     * @return self
     */
    public function setNewsId(int $newsId): self
    {
        $this->newsId = $newsId;

        return $this;
    }

    /**
     * Get the ID of the related news item.
     *
     * @return int
     */
    public function getNewsId(): int
    {
        return $this->newsId;
    }
}
