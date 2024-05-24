<?php

namespace Mark\Services;

use Mark\Models\News;
use Mark\Libraries\Database;

/**
 * Class NewsService
 * 
 * Service class to manage news operations.
 * 
 * @package Mark\Services
 */
class NewsService
{
    /**
     * @var Database The database instance
     */
    private Database $db;

    /**
     * NewsService constructor.
     * 
     * @param Database $db The database instance
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * List all news.
     *
     * @return News[] An array of News objects
     */
    public function listNews(): array
    {
        $rows = $this->db->select('SELECT * FROM `news`');

        $news = [];
        foreach ($rows as $row) {
            $n = new News();
            $news[] = $n->setId((int)$row['id'])
                ->setTitle($row['title'])
                ->setBody($row['body'])
                ->setCreatedAt(new \DateTime($row['created_at']));
        }

        return $news;
    }

    /**
     * Add a record in the news table.
     *
     * @param string $title The title of the news
     * @param string $body The body content of the news
     * @return int The ID of the newly inserted news record
     */
    public function addNews(string $title, string $body): string
    {
        $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES (:title, :body, :created_at)";
        $params = [
            ':title' => $title,
            ':body' => $body,
            ':created_at' => date('Y-m-d'),
        ];
        $this->db->exec($sql, $params);
        return $this->db->lastInsertId();
    }

    /**
     * Deletes a news item.
     *
     * @param int $id The ID of the news item to delete
     * @return int The number of rows affected
     */
    public function deleteNews(int $id): int
    {
        $sql = "DELETE FROM `news` WHERE `id` = :id";
        $params = [':id' => $id];
        return $this->db->exec($sql, $params);
    }
}
