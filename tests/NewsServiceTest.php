<?php

use PHPUnit\Framework\TestCase;
use Mark\Services\NewsService;
use Mark\Models\News;
use Mark\Libraries\Database;

class NewsServiceTest extends TestCase
{
    public function testListNews()
    {
        // Mock the Database class
        $dbMock = $this->createMock(Database::class);

        // Set up the expected data from the database
        $expectedRows = [
            ['id' => 1, 'title' => 'News 1', 'body' => 'Body 1', 'created_at' => '2024-05-25'],
            ['id' => 2, 'title' => 'News 2', 'body' => 'Body 2', 'created_at' => '2024-05-26'],
        ];

        // Expect the select method to be called once and return the expected rows
        $dbMock->expects($this->once())
            ->method('select')
            ->with('SELECT * FROM `news`')
            ->willReturn($expectedRows);

        // Instantiate the NewsService with the mocked Database
        $newsService = new NewsService($dbMock);

        // Call the method under test
        $newsList = $newsService->listNews();

        // Assert that the method returns an array of News objects
        $this->assertIsArray($newsList);
        $this->assertCount(2, $newsList);

        // Assert that each item in the news list is a News object with the correct properties
        foreach ($newsList as $news) {
            $this->assertInstanceOf(News::class, $news);
        }
    }

    public function testDeleteNews()
    {
        // Mock the Database class
        $dbMock = $this->createMock(Database::class);

        // Expect the exec method to be called once with the correct SQL query and parameters
        $dbMock->expects($this->once())
            ->method('exec')
            ->with(
                $this->equalTo("DELETE FROM `news` WHERE `id` = :id"),
                $this->equalTo([':id' => 1])
            )
            ->willReturn(1); // Assuming 1 row affected

        // Instantiate the NewsService with the mocked Database
        $newsService = new NewsService($dbMock);

        // Call the method under test
        $affectedRows = $newsService->deleteNews(1);

        // Assert that the method returns the number of affected rows
        $this->assertEquals(1, $affectedRows);
    }

    public function testAddNews()
    {
        // Mock the Database class
        $dbMock = $this->createMock(Database::class);

        // Expect the exec method to be called once with the correct SQL query and parameters
        $dbMock->expects($this->once())
            ->method('exec')
            ->with(
                $this->equalTo('INSERT INTO `news` (`title`, `body`, `created_at`) VALUES (:title, :body, :created_at)'),
                $this->equalTo([
                    ':title' => 'New Title',
                    ':body' => 'Body Comment',
                    ':created_at' => date('Y-m-d'),
                ])
            )
            ->willReturn(1); // Assuming 1 row affected

        // Mock the lastInsertId method of the Database class to return a string ID
        $dbMock->method('lastInsertId')->willReturn('3');

        // Instantiate the CommentService with the mocked Database
        $news = new NewsService($dbMock);

        // Call the method under test
        $newId = $news->addNews('New Title', 'Body Comment');

        // Assert that the method returns the expected ID
        $this->assertEquals('3', $newId); // Expecting a string ID
    }
}
