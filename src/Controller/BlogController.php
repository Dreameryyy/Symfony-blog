<?php
// src/Controller/BlogController.php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Form\BlogType;
use App\Form\CommentType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class BlogController extends AbstractController
{
    /**
     * Displays a paginated list of blogs.
     *
     * @param BlogRepository $blogsRepository The repository to fetch blogs.
     * @param PaginatorInterface $paginator The paginator service.
     * @param Request $request The current request.
     * @return Response The response containing the rendered view.
     */
    #[Route('/blog', name: 'app_blog_index')]
    public function index(BlogRepository $blogsRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Create a query to fetch all blogs
        $query = $blogsRepository->createQueryBuilder('b')->getQuery();

        // Paginate the results of the query
        $pagination = $paginator->paginate(
            $query, // Query to paginate
            $request->query->getInt('page', 1), // Current page number, defaulting to 1
            10 // Number of items per page
        );

        // Render the view with the paginated blogs
        return $this->render('blog/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
    * Displays a single blog with its comments and a form to add a new comment.
    *
    * @param int $id The ID of the blog to display.
    * @param BlogRepository $blogRepository The repository to fetch the blog.
    * @param Request $request The current request.
    * @param EntityManagerInterface $em The entity manager.
    * @param PaginatorInterface $paginator The paginator service.
    * @return Response The response containing the rendered view.
    */
    #[Route('/blog/{id<\d+>}', name: 'app_blog_show')]
    public function show(int $id, BlogRepository $blogRepository, Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {

        // Fetch the blog with its comments using a custom repository method
        $blog = $blogRepository->findOneWithComments($id);

        // Throw an exception if the blog is not found
        if (!$blog) {
            throw $this->createNotFoundException('The blog does not exist');
        }

        // Create a new comment and associate it with the blog
        $comment = new Comment();
        $comment->setBlog($blog);

        // Create a form to add a new comment
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the new comment to the database
            $em->persist($comment);
            $em->flush();

            // Redirect to the same blog page after adding the comment
            return $this->redirectToRoute('app_blog_show', ['id' => $blog->getId()]);
        }

        // Paginate comments
        $commentsQuery = $blog->getComments();
        $pagination = $paginator->paginate(
            $commentsQuery,
            $request->query->getInt('page', 1),
            5 // Number of comments per page
        );

        // Render the view with the blog, its paginated comments, and the comment form
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
            'pagination' => $pagination, // Pass the pagination object to the template
            'form' => $form->createView(),
        ]);
    }

    /**
     * Creates a new blog.
     *
     * @param Request $request The current request.
     * @param EntityManagerInterface $em The entity manager.
     * @return Response The response containing the rendered view.
     */
    #[Route('/blog/new', name: 'app_blog_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // Create a new Blog entity
        $blog = new Blog();

        // Create a form to create a new blog
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the new blog to the database
            $em->persist($blog);
            $em->flush();

            // Redirect to the blog index page after creating the blog
            return $this->redirectToRoute('app_blog_index');
        }

        // Render the view with the blog creation form
        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}