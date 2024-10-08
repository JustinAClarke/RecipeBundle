<?php
namespace App\NoticeBoardBundle\Controller;

// Will Remove Just temp whilst creating form --
use App\NoticeBoardBundle\Entity\NoticeBoardNotices;
use App\NoticeBoardBundle\Entity\NoticeBoards;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
// -- Will Remove Just temp whilst creating form

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use JustinFuhrmeisterClarke\AnalyticsBundle\Controller\AnalyticsIncludes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

class DefaultController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    public function index()
    {
        // $log = new AnalyticsIncludes();

        return $this->render('@NoticeBoardBundle/Default/index.html.twig');
    }
    public function listBoards()
    {
    	$NoticeBoard = $this->getBoards();
        return $this->render('@NoticeBoardBundle/Default/listBoards.html.twig', array('NoticeBoards' => $NoticeBoard));
    }

    public function showBoard($slug)
    {
        // $NoticeBoardList = $this->getNotices($slug);
		$NoticeBoardList = $this->getNoticesOrdered($slug);
        return $this->render('@NoticeBoardBundle/Default/showBoard.html.twig', array('list' => $NoticeBoardList));
    }

    public function listBoardsNotices()
    {
    	$boards = $this->getBoards();
        return $this->render('@NoticeBoardBundle/Default/listBoardslistNotices.html.twig', array('Boards' => $boards, 'display' => 'list'));
        //display "list" / "grid" will display the notices in either a grid or list view, and change the general display of the page
        //TODO: fix listBoardsListNotices.html.twig page to check if display is list or grid, then get the renderer and controller for that function,
    }

    public function showNotice($slug)
    {
    	$Notice = $this->getNotice($slug);
        return $this->render('@NoticeBoardBundle/Default/showNotice.html.twig', array('Notice' => $Notice));
    }

    public function showNoticeCommonAction($slug,$showtitle,$showimage)
    {
    	$Notice = $this->getNotice($slug);
        return $this->render('@NoticeBoardBundle/Default/showNoticeCommon.html.twig', array('Notice' => $Notice,'showtitle'=>$showtitle,'showimage'=>$showimage));
    }
    
    public function showSidebySideAction($slug1,$slug2)
    {
    	//$first = $this->getNotice($slug);
	//$second = $this->getNoticeAction($slug2);
		$allRecipies = $this->getAllNotices();

        return $this->render('@NoticeBoardBundle/Default/showNoticeSide.html.twig', array('view1' => $slug1,'view2'=>$slug2, 'all'=>$allRecipies));
    }
    
    public function showSidebySideSingleAction($slug1)
    {
    	//$first = $this->getNotice($slug);
	//$second = $this->getNoticeAction($slug2);
	$allRecipies = $this->getAllNotices();
        return $this->render('@NoticeBoardBundle/Default/showNoticeSide.html.twig', array('view1' => $slug1,'view2'=>false, 'all'=>$allRecipies));
    }
    
    
    public function showNoticeGrid($slug)
    {
    	$Notice = $this->getNotices($slug);
        // return $this->render('@NoticeBoardBundle/Default/noticeListView.html.twig', array('notice' => $Notice));
        return $this->render('@NoticeBoardBundle/Default/noticeGridView.html.twig', array('notice' => $Notice));
    }

    public function showNoticeList($slug)
    {
        $Notice = $this->getNotices($slug);
        // return $this->render('@NoticeBoardBundle/Default/noticeListView.html.twig', array('notice' => $Notice));
        return $this->render('@NoticeBoardBundle/Default/noticeListView.html.twig', array('notice' => $Notice));
    }

    public function showAbout()
    {
        return $this->render('@NoticeBoardBundle/Default/about.html.twig');
    }

    public function categoriesNav()
    {
        $boards = $this->getBoards();
        return $this->render('@NoticeBoardBundle/Default/categoriesNav.html.twig', array('boards' => $boards));
    }

    public function addNotice(Request $request)
    {

        $notice = new NoticeBoardNotices();
        // $boardsform = new NoticeBoards();
        
        $boards = $this->getAllBoards();
        
        $Boards = array();
        $label = array();
        $value = array();

//        for ($i=0; $i < sizeof($boards); $i++) {
//            array_push($value, $boards[$i]['title']);
//            array_push($label, $boards[$i]['title']);
//        }
        // array_push($value, "Add New");
        // array_push($label, "Add New");

        $Boards = array_combine($value, $label);
        // $formBoard = $this->createFormBuilder($boardsform)
        // ->add('title', TextType::class)
        // ->add('save', SubmitType::class, array('label' => 'Create Board'))
        // ->getForm();
        $boardsI18n = 'recipe.categories';

        $form = $this->createFormBuilder($notice)
        ->add('title', TextType::class)
        ->add('Board', ChoiceType::class, array(
            'choices' => array($boardsI18n => $boards),
            'choice_value' => 'title',
            'choice_label' => function(?NoticeBoards $noticeBoard) {
                return $noticeBoard ? strtoupper($noticeBoard->getTitle()) : '';
            },
            // returns the html attributes for each option input (may be radio/checkbox)
            'choice_attr' => function(?NoticeBoards $noticeBoard) {
                return $noticeBoard ? ['class' => 'noticeBoard_'.strtolower($noticeBoard->getTitle())] : [];
            },
        ))
        ->add('requirements', TextareaType::class, array('required' => false))
        ->add('image', FileType::class, array('required' => false))
        ->add('content', TextareaType::class, array('required' => false))
        ->add('notes', TextareaType::class, array('required' => false))
        ->add('save', SubmitType::class, array('label' => 'Create notice'))
        ->getForm();
        // $NoticeBoard = $repository->findAll();

        //$formBoard->handleRequest($request);
        $form->handleRequest($request);

        // var_dump($form);
        //die;
        // if ($formBoard->isSubmitted() ) {
            // code...
            // $em = $this->$this->doctrine->getManager();
            // $em->persist($formBoard); //commit to temp variable
            // $em->flush(); //Commit to Database
        // }
        if($form->isSubmitted() ) //&& $form->isValid())
        {

            $em = $this->doctrine->getManager();
            $newNotice = new NoticeBoardNotices();
            
            $file = $notice->getImage();
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            if($file != null){
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $recipeImageDir = $this->container->getParameter('kernel.root_dir').'/../web/recipe/images';
                $file->move($recipeImageDir, $fileName);
            }
            else
            {
                $fileName = null;
            }


            $newNotice->setImage($fileName);


            //$newNotice->setId(1);
            
            /*// echo "Submit<hr>";
// 
            // echo "Form Title<hr>";
            print_r($form['title']->getData());
            echo "<hr>htmlentities()<hr>";
            print_r(htmlentities($form['title']->getData()));

            echo "<hr>Form Board<hr>";
            print_r($form['Board']->getData());
            echo "<hr>htmlentities()<hr>";
            print_r(htmlentities($form['Board']->getData()));
            
            echo "<hr>Form requirements<hr>";
            print_r($form['requirements']->getData());
            echo "<hr>htmlentities()<hr>";
            print_r(htmlentities($form['requirements']->getData()));

            echo "<hr>Form Content<hr>";
            print_r($form['content']->getData());
            echo "<hr>htmlentities()<hr>";
            print_r(htmlentities($form['content']->getData()));

            echo "<hr>Form notes<hr>";
            print_r($form['notes']->getData());
            echo "<hr>htmlentities()<hr>";
            print_r(htmlentities($form['notes']->getData()));
            echo "<hr><hr>";
            
            */


            $newNotice->setTitle($form['title']->getData());
            $newNotice->setBoard($form['Board']->getData());
            $newNotice->setRequirements($form['requirements']->getData());
            $newNotice->setContent($form['content']->getData());
            $newNotice->setNotes($form['notes']->getData());
            $em->persist($newNotice); //commit to temp variable
            // $em->persist($form); //commit to temp variable
            $em->flush(); //Commit to Database
            // $NoticeID = $form->getId();
            $NoticeID = $newNotice->getId();
            return $this->redirect($this->generateUrl('showNotice', array('slug'=>$NoticeID)));
            //return $this->redirectToRoute("showNotice, {'slug:'," . $NoticeID ."}");
        }
        

        return $this->render('@NoticeBoardBundle/Default/add.html.twig', array('form' => $form->createView(), 'image' => null
        ));

    }
    public function editNotice($slug, Request $request)
    {

        //$data = getNotice($slug);
        $repository = $this->doctrine->getRepository(NoticeBoardNotices::class);
        $Notice = "";
        if($repository->findById($slug))
        {
            //get Notice by ID
            $Notice = $repository->find($slug);
        }
        elseif ($repository->findByTitle($slug))
        {
            //else get notice by Title
            $Notice = $repository->find($slug);
        }

        // $notice = new NoticeBoardNotices();
    	//$notice = $this->getNotice($slug);
        //$Notice = array('notice'=>$notice);
        // $boardsform = new NoticeBoards();
		
		$Boards = $this->getAllBoards();
		
//		$Boards = array();
		$label = array();
		$value = array();

//		for ($i=0; $i < sizeof($boards); $i++) {
//			array_push($value, $boards[$i]['title']);
//			array_push($label, $boards[$i]['title']);
//		}
		// array_push($value, "Add New");
		// array_push($label, "Add New");

//		$Boards = array_combine($value, $label);
        // $formBoard = $this->createFormBuilder($boardsform)
        // ->add('title', TextType::class)
        // ->add('save', SubmitType::class, array('label' => 'Create Board'))
        // ->getForm(); 
        // var_dump($repository);
        // var_dump($Notice->getTitle());
        //var_dump($notice->getTitle());
        // die;+
		$form = $this->createFormBuilder($Notice)
		->add('title', TextType::class)
            ->add('Board', ChoiceType::class, array(
                'choices' => array('Boards' => $Boards),
                'choice_value' => 'title',
                'choice_label' => function(?NoticeBoards $noticeBoard) {
                    return $noticeBoard ? strtoupper($noticeBoard->getTitle()) : '';
                },
                // returns the html attributes for each option input (may be radio/checkbox)
                'choice_attr' => function(?NoticeBoards $noticeBoard) {
                    return $noticeBoard ? ['class' => 'noticeBoard_'.strtolower($noticeBoard->getTitle())] : [];
                },
            ))
		->add('requirements', TextareaType::class, array('required' => false))
        ->add('image', FileType::class, array('data' => null, 'required' => false))
        // ->add('image', FileType::class, array('data' => $Notice->getImage()))
		->add('content', TextareaType::class, array('required' => false))
		->add('notes', TextareaType::class, array('required' => false))
		->add('save', SubmitType::class, array('label' => 'Create notice'))
		->getForm();
		// $NoticeBoard = $repository->findAll();

        //$formBoard->handleRequest($request);
		$form->handleRequest($request);

		// var_dump($form);
		//die;
        // if ($formBoard->isSubmitted() ) {
            // code...
            // $em = $this->$this->doctrine->getManager();
            // $em->persist($formBoard); //commit to temp variable
            // $em->flush(); //Commit to Database
        // }
		if($form->isSubmitted() ) //&& $form->isValid())
		{

			$em = $this->doctrine->getManager();
			$newNotice = new NoticeBoardNotices();

            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();
            if($file != null){
                $fileName = md5(uniqid()).'.'.$file->getClientOriginalExtension();


                $file->move($this->getParameter('kernel.project_dir') . '/public/recipe/images', $fileName);
            }
            else
            {
                $fileName = null;
            }
            

            $Notice->setImage($fileName);

			//$newNotice->setId(1);
			
			/*// echo "Submit<hr>";
// 
			// echo "Form Title<hr>";
			print_r($form['title']->getData());
			echo "<hr>htmlentities()<hr>";
			print_r(htmlentities($form['title']->getData()));

			echo "<hr>Form Board<hr>";
			print_r($form['Board']->getData());
			echo "<hr>htmlentities()<hr>";
			print_r(htmlentities($form['Board']->getData()));
			
			echo "<hr>Form requirements<hr>";
			print_r($form['requirements']->getData());
			echo "<hr>htmlentities()<hr>";
			print_r(htmlentities($form['requirements']->getData()));

			echo "<hr>Form Content<hr>";
			print_r($form['content']->getData());
			echo "<hr>htmlentities()<hr>";
			print_r(htmlentities($form['content']->getData()));

			echo "<hr>Form notes<hr>";
			print_r($form['notes']->getData());
			echo "<hr>htmlentities()<hr>";
			print_r(htmlentities($form['notes']->getData()));
			echo "<hr><hr>";
			
			*/


			$Notice->setTitle($form['title']->getData());
			$Notice->setBoard($form['Board']->getData());
			$Notice->setRequirements($form['requirements']->getData());
			$Notice->setContent($form['content']->getData());
			$Notice->setNotes($form['notes']->getData());
			$em->persist($Notice); //commit to temp variable
			// $em->persist($form); //commit to temp variable
			$em->flush(); //Commit to Database
            // $NoticeID = $form->getId();
			$NoticeID = $Notice->getId();
            return $this->redirect($this->generateUrl('showNotice', array('slug'=>$NoticeID)));
			//return $this->redirectToRoute("showNotice, {'slug:'," . $NoticeID ."}");
		}
		

        return $this->render('@NoticeBoardBundle/Default/add.html.twig', array('form' => $form->createView(), 'image' => $Notice->getImage()
        ));

    }

    public function search(){
	$results="";
        if (isset($_GET['q'])) {
            // var_dump($_GET);
            $q = "%" . $_GET["q"] . "%";
            $searchArray = array();            
            if (isset($_GET['title'])) {
                # code...
                array_push($searchArray, 'p.title like :query' );
            }
            if (isset($_GET['requirements'])) {
                # code...
                array_push($searchArray, 'p.requirements like :query' );
            }
            if (isset($_GET['method'])) {
                # code...
                array_push($searchArray, 'p.content like :query' );
            }
            if (isset($_GET['notes'])) {
                # code...
                array_push($searchArray, 'p.notes like :query' );
            }

            // if searchArray is empty, then search all fields
            if (empty($searchArray)) {
                $searchArray = array('p.title like :query', 'p.requirements like :query', 'p.content like :query', 'p.notes like :query');
            }
            $searchQuery = implode(" or ", $searchArray);
            // echo "<br>";
            // echo $searchQuery;
            
            $em = $this->doctrine->getManager();
	    $query = $em->createQuery(
	      'SELECT p
            FROM NoticeBoardBundle:NoticeBoardNotices p
            WHERE ' . $searchQuery )->setParameter('query', $q );
        
	     $results = $query->getResult();
        }
        

        // echo "<br>";
        // var_dump($results);

        //$em = $this->$this->doctrine->getManager();
        ////MariaDB [test]> select * from test2 where name like "%glks%" || title like "%;%";
        //$query = $em->createQuery(
        //    'SELECT p
        //    FROM AppBundle:Product p
        //    WHERE p.price > :price
        //    ORDER BY p.price ASC'
        //)->setParameter('price', '19.99');
        //
        //$products = $query->getResult();
        // return $this->render('@NoticeBoardBundle/Default/noticeListView.html.twig', array('notice' => $Notice));


        return $this->render('@NoticeBoardBundle/Default/search.html.twig', array('notice' => $results, 'search' => $_GET));
    }

    //----------------------------------------------------------------------------------------------------
    //Create Functions to move to external class /file.

    //get boards
    //to get the list of boards
    public function getBoards()
    {
        $repository = $this->doctrine->getRepository(NoticeBoards::class);
        $Boards     = $repository->findAll();
        return $Boards;
    }
    //get all boards
    public function getAllBoards()
    {
        $Boardrepository = $this->doctrine->getRepository(NoticeBoards::class);
        $boards          = $Boardrepository->findAll();
        return $boards;
    }
    //get notices / $board
    //to return the notices from $board
    public function getNotices($board)
    {
        $em          = $this->doctrine->getManager();
        $repository  = $this->doctrine->getRepository(NoticeBoardNotices::class);
        $NoticesList = $em->getRepository(NoticeBoardNotices::class)->findBy(array('board' => $board), array('title' => 'ASC'));
        // $NoticesList = $repository->findByBoard($board);
        return $NoticesList;
    }
    public function getNoticesOrdered($board)
    {
        $em = $this->doctrine->getManager();

        $NoticesList = $em->getRepository(NoticeBoardNotices::class)->findBy(array('board' => $board), array('title' => 'ASC'));

        // $em          = $this->$this->doctrine->getManager();
        // $repository  = $this->$this->doctrine->getRepository(NoticeBoardNotices::class);
        // $NoticesList = $repository->findByBoard($board);
        return $NoticesList;
    }
    
    public function getAllNotices(){
            $em = $this->doctrine->getManager();

        $NoticesList = $em->getRepository(NoticeBoardNotices::class)->findBy(array());
        //$NoticesList = $em->getRepository(NoticeBoardNotices::class)->findBy(array('board' => $board), array('title' => 'ASC'));

    return $NoticesList;
    }
    
    //get notice ($title || $id) == $slug
    //to return the notice, either from $id or $title
    public function getNotice($slug)
    {
		$repository = $this->doctrine->getRepository(NoticeBoardNotices::class);
		$Notice = "";
		if($repository->findById($slug))
		{
			//get Notice by ID
			$Notice = $repository->findById($slug);
		}
		elseif ($repository->findByTitle($slug))
		{
			//else get notice by Title
			$Notice = $repository->findByTitle($slug);	
		}
        return $Notice;
    }
    //create board / $title
    //to create a board by the name $title
    public function createBoard($title)
    {
    	$em = $this->doctrine->getManager();
		$NoticeBoards = new NoticeBoards();
		$NoticeBoards->setTitle($title);
		$em->persist($NoticeBoards); //commit to temp variable
		$em->flush(); //Commit to Database
		$em->clear();
		if($em->getId() != "")
        	return 0;
    	else
    		return -1;

    }
    //delete board / ($title || $id) == $slug
    //to delete the board and all assiated notices
    public function deleteBoard($slug)
    {
    	$em = $this->doctrine->getManager();
    	$em->remove($slug);
		$em->flush();
        return "test";
    }
    //create notice $data
    //to create a notice with title, board, req, etc
    public function createNotice($data)
    {
    	$notice = new NoticeBoardNotices();
    	$boards = $this->getAllBoards();
        return "test";
    }
    //delete notice / ($title || $id) == $slug
    //to delete notice known by $id or $title
    public function deleteNotice($slug)
    {
        return "test";
    }

}
