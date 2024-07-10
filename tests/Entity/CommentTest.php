<?php

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Blog;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testCommentEntity()
    {
        // Create a new Comment instance
        $comment = new Comment();
        
        // Test setting and getting the content
        $content = 'This is a comment';
        $comment->setContent($content);
        $this->assertEquals($content, $comment->getContent());

        // Test setting and getting the author
        $author = 'John Doe';
        $comment->setAuthor($author);
        $this->assertEquals($author, $comment->getAuthor());

        // Test setting and getting the email
        $email = 'johndoe@example.com';
        $comment->setEmail($email);
        $this->assertEquals($email, $comment->getEmail());

        // Test setting and getting the blog
        $blog = new Blog();
        $comment->setBlog($blog);
        $this->assertEquals($blog, $comment->getBlog());
    }
}
