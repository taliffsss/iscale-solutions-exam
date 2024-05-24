<?php

namespace Mark\Services;

use Mark\Models\Comment;
use Mark\Libraries\Database;

/**
 * Class CommentService
 * 
 * Service class to manage comment operations.
 * 
 * @package Mark\Services
 */
class CommentService
{
    /**
     * @var Database Database instance
     */
    private Database $db;

    /**
     * Constructor to inject the database instance.
     *
     * @param DB $db Database instance
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * List all comments.
     *
     * @return Comment[] The list of comments
     */
    public function listComments(): array
    {
        $rows = $this->db->select('SELECT * FROM `comment`');

        $comments = [];
        foreach ($rows as $row) {
            $comment = new Comment();
            $comment->setId($row['id'])
                ->setBody($row['body'])
                ->setCreatedAt(new \DateTime($row['created_at']))
                ->setNewsId($row['news_id']);
            $comments[] = $comment;
        }

        return $comments;
    }

    /**
     * Add a comment for a news item.
     *
     * @param string $body The body of the comment
     * @param int $newsId The ID of the news item
     * @return string The ID of the inserted comment
     */
    public function addCommentForNews(string $body, int $newsId): string
    {
        $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES (:body, :created_at, :news_id)";
        $params = [
            ':body' => $body,
            ':created_at' => date('Y-m-d'),
            ':news_id' => $newsId
        ];
        $this->db->exec($sql, $params);
        return $this->db->lastInsertId();
    }

    /**
     * Delete a comment by ID.
     *
     * @param int $id The ID of the comment to delete
     * @return int The number of affected rows
     */
    public function deleteComment(int $id): int
    {
        $sql = "DELETE FROM `comment` WHERE `id` = :id";
        $params = [':id' => $id];
        return $this->db->exec($sql, $params);
    }
}
