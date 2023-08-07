<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException as ExceptionAccessDeniedException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException as FileExceptionAccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BookController extends AbstractController
{
    #[Route('/book/all/book', name: 'library_all_book')]
    public function index(BookRepository $bookRepo): Response
    
    {
        //demander les books au repository
        $books = $bookRepo->findAll();
        //appel de le vue, on passe les books
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    
    #[Route('/book/newBook', name:'add_book')]
    public function createBook(Book $book=null, Request $req, EntityManagerInterface $em):Response{
        //creer un nouveau book
         try{
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $book = new Book(); 

            //creer le formulaire
            $form = $this->createForm(BookFormType::class, $book);
            $form->handleRequest($req);

            if($form->isSubmitted()&& $form->isValid()){
                $em->persist($book);
                //envoi du form 
                $em->flush();
            }
            //creer la vue
                return $this->render('book/add_book.html.twig',[
                'bookForm'=>$form->createView(),       
            ]);
        
        }
            catch(AccessDeniedException $ex){
                $this->addFlash('error',"l'accès à cette ressources est interdite"); 
            return $this->render('error/error.html.twig');
             //redirige
            return$this->redirectToRoute('library_all_book');
           
        } 
    }

    #[Route('/book/updateBook/{id}', name:'update_book')]
    public function updateBook(Book $book, Request $req, EntityManagerInterface $em): Response
    {
        try{
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            //creer le formulaire
            $form = $this->createForm(BookFormType::class, $book);

            $form->handleRequest($req);

            if($form->isSubmitted()&& $form->isValid()){
            $em->persist($book);

            //envoi du form 
            $em->flush();
        }  
        //affiche la vue
            return $this->render('book/update_book.html.twig',[
            'bookForm'=>$form->createView(),       
            ]);  
        }
        catch(AccessDeniedException $ex){
            $this->addFlash('error',"l'accès à cette ressources est interdite"); 
            return $this->render('error/error.html.twig');
           //redirige
            return $this->redirectToRoute('library_all_book'); 
        }
    }
    
    #[Route ('/book/delBook/{id}', name:'del_book')]
    public function deleteBook(Book $book, Request $req, EntityManagerInterface $em){
        try{
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        //supprime le book
        $em->remove($book);
        //envoi
        $em->flush(); 
        }
        catch(AccessDeniedException $ex){
            $this->addFlash('error',"l'accès à cette ressources est interdite"); 
            return $this->render('error/error.html.twig');
          //redirige
          return $this->redirectToRoute('library_all_book');    
        }  
        
    }
    
    #[Route('/home', name:'home')]
    public function home(){
        return $this->render('book/home.html.twig',[
            
            
        ]);
    }

}
