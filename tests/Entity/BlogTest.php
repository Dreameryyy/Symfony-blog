<?php
// tests/Entity/BlogTest.php

namespace App\Tests\Entity;

use App\Entity\Blog;
use PHPUnit\Framework\TestCase;

class BlogTest extends TestCase
{
    public function testBlog(): void
    {
        $blog = new Blog();
        $blog->setTitle('Test Title');
        $blog->setDescription('Test description');
        $blog->setContent('Test Content');
        $blog->setAuthor('Test Author');
        $blog->setEmail('author@test.com');

        $this->assertEquals('Test Title', $blog->getTitle());
        $this->assertEquals('Test description', $blog->getDescription());
        $this->assertEquals('Test Content', $blog->getContent());
        $this->assertEquals('Test Author', $blog->getAuthor());
        $this->assertEquals('author@test.com', $blog->getEmail());
    }
}
