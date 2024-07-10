<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * Fetch comments by blog ID.
     *
     * @param int $blogId The ID of the blog
     * @return Comment[] Returns an array of Comment objects
     */
    public function findByBlogId(int $blogId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.blog = :blogId')
            ->setParameter('blogId', $blogId)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

   
}
