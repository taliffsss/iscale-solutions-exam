<?php

use PHPUnit\Framework\TestCase;
use Mark\Services\CommentService;
use Mark\Models\Comment;
use Mark\Libraries\Database;

class CommentServiceTest extends TestCase
{
    public function testListComments()
    {
        // Mock the Database class
        $dbMock = $this->createMock(Database::class);

        // Set up the expected data from the database
        $expectedRows = [
            ['id' => 1, 'body' => 'Comment 1', 'created_at' => '2024-05-25', 'news_id' => 1],
            ['id' => 2, 'body' => 'Comment 2', 'created_at' => '2024-05-26', 'news_id' => 2],
        ];

        // Expect the select method to be called once and return the expected rows
        $dbMock->expects($this->once())
            ->method('select')
            ->with('SELECT * FROM `comment`')
            ->willReturn($expectedRows);

        // Instantiate the CommentService with the mocked Database
        $commentService = new CommentService($dbMock);

        // Call the method under test
        $commentList = $commentService->listComments();

        // Assert that the method returns an array of Comment objects
        $this->assertIsArray($commentList);
        $this->assertCount(2, $commentList);

        // Assert that each item in the comment list is a Comment object with the correct properties
        foreach ($commentList as $comment) {
            $this->assertInstanceOf(Comment::class, $comment);
        }
    }

    public function testAddCommentForNews()
    {
        // Mock the Database class
        $dbMock = $this->createMock(Database::class);

        // Expect the exec method to be called once with the correct SQL query and parameters
        $dbMock->expects($this->once())
            ->method('exec')
            ->with(
                $this->equalTo('INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES (:body, :created_at, :news_id)'),
                $this->equalTo([
                    ':body' => 'New Comment',
                    ':created_at' => date('Y-m-d'),
                    ':news_id' => 1
                ])
            )
            ->willReturn(1); // Assuming 1 row affected

        // Mock the lastInsertId method of the Database class to return a string ID
        $dbMock->method('lastInsertId')->willReturn('3');

        // Instantiate the CommentService with the mocked Database
        $commentService = new CommentService($dbMock);

        // Call the method under test
        $newId = $commentService->addCommentForNews('New Comment', 1);

        // Assert that the method returns the expected ID
        $this->assertEquals('3', $newId); // Expecting a string ID
    }

    public function testDeleteComment()
    {
        // Mock the Database class
        $dbMock = $this->createMock(Database::class);

        // Expect the exec method to be called once with the correct SQL query and parameters
        $dbMock->expects($this->once())
            ->method('exec')
            ->with(
                $this->equalTo('DELETE FROM `comment` WHERE `id` = :id'),
                $this->equalTo([':id' => 1])
            )
            ->willReturn(1); // Assuming 1 row affected

        // Instantiate the CommentService with the mocked Database
        $commentService = new CommentService($dbMock);

        // Call the method under test
        $affectedRows = $commentService->deleteComment(1);

        // Assert that the method returns the number of affected rows
        $this->assertEquals(1, $affectedRows);
    }
}
