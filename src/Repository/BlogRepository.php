<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Blog>
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    /**
     * Fetch all blogs with their comments eagerly loaded.
     *
     * @return Blog[] Returns an array of Blog objects
     */
    public function findAllWithComments(): array
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.comments', 'c') 
            ->addSelect('c')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find a blog by ID with its comments eagerly loaded.
     *
     * @param int $id The ID of the blog to find
     * @return Blog|null Returns a Blog object or null if not found
     */
    public function findOneWithComments(int $id): ?Blog
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->leftJoin('b.comments', 'c') 
            ->addSelect('c')
            ->getQuery()
            ->getOneOrNullResult();
    }

}

