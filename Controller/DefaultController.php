<?php
namespace NoticeBoardBundle\Controller;

// Will Remove Just temp whilst creating form --
use Symfony\Component\BrowserKit\Response;	
use NoticeBoardBundle\Entity\NoticeBoardNotices;
use NoticeBoardBundle\Entity\NoticeBoards;
use NoticeBoardBundle\Entity\BloodFoods;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
// -- Will Remove Just temp whilst creating form

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JustinFuhrmeisterClarke\AnalyticsBundle\Controller\AnalyticsIncludes;


class DefaultController extends Controller
{
    public function indexAction()
    {
        // $log = new AnalyticsIncludes();

        return $this->render('NoticeBoardBundle:Default:index.html.twig');
    }
    public function listBoardsAction()
    {
    	$NoticeBoard = $this->getBoardsAction();
        return $this->render('NoticeBoardBundle:Default:listBoards.html.twig', array('NoticeBoards' => $NoticeBoard));
    }

    public function showBoardAction($slug)
    {
        // $NoticeBoardList = $this->getNoticesAction($slug);
		$NoticeBoardList = $this->getNoticesOrderedAction($slug);
        return $this->render('NoticeBoardBundle:Default:showBoard.html.twig', array('list' => $NoticeBoardList));
    }

    public function listBoardsNoticesAction()
    {
    	$boards = $this->getBoardsAction();
        return $this->render('NoticeBoardBundle:Default:listBoardslistNotices.html.twig', array('Boards' => $boards, 'display' => 'list'));
        //display "list" / "grid" will display the notices in either a grid or list view, and change the general display of the page
        //TODO: fix listBoardsListNotices.html.twig page to check if display is list or grid, then get the renderer and controller for that function,
    }

    public function showNoticeAction($slug)
    {
    	$Notice = $this->getNoticeAction($slug);
        return $this->render('NoticeBoardBundle:Default:showNotice.html.twig', array('Notice' => $Notice));
    }

    public function showNoticeCommonAction($slug,$showtitle,$showimage)
    {
    	$Notice = $this->getNoticeAction($slug);
        return $this->render('NoticeBoardBundle:Default:showNoticeCommon.html.twig', array('Notice' => $Notice,'showtitle'=>$showtitle,'showimage'=>$showimage));
    }
    
    public function showSidebySideAction($slug1,$slug2)
    {
    	//$first = $this->getNoticeAction($slug);
	//$second = $this->getNoticeAction($slug2);
		$allRecipies = $this->getAllNotices();

        return $this->render('NoticeBoardBundle:Default:showNoticeSide.html.twig', array('view1' => $slug1,'view2'=>$slug2, 'all'=>$allRecipies));
    }
    
    public function showSidebySideSingleAction($slug1)
    {
    	//$first = $this->getNoticeAction($slug);
	//$second = $this->getNoticeAction($slug2);
	$allRecipies = $this->getAllNotices();
        return $this->render('NoticeBoardBundle:Default:showNoticeSide.html.twig', array('view1' => $slug1,'view2'=>false, 'all'=>$allRecipies));
    }
    
    
    public function showNoticeGridAction($slug)
    {
    	$Notice = $this->getNoticesAction($slug);
        // return $this->render('NoticeBoardBundle:Default:noticeListView.html.twig', array('notice' => $Notice));
        return $this->render('NoticeBoardBundle:Default:noticeGridView.html.twig', array('notice' => $Notice));
    }

    public function showNoticeListAction($slug)
    {
        $Notice = $this->getNoticesAction($slug);
        // return $this->render('NoticeBoardBundle:Default:noticeListView.html.twig', array('notice' => $Notice));
        return $this->render('NoticeBoardBundle:Default:noticeListView.html.twig', array('notice' => $Notice));
    }

    public function showBloodTypeFoodsAction(){
        //get blood foods from DB then send to renderer to display.
        $repository = $this->getDoctrine()->getRepository('NoticeBoardBundle:BloodFoods');
        $foods     = $repository->findAll();
        $MeatPoultry = array();
        $FishSeafood = array();
        $DairyEggs = array();
        $BeansLegumes = array();
        $NutsSeeds = array();
        $GrainsStarches = array();
        $Vegetables = array();
        $FruitsJuices = array();
        $Oils = array();
        $HerbsSpicesCondiments = array();
        $Beverages = array();
        foreach ($foods as $row) {
            # code...
            switch ($row->getCat()) {
                case 'MeatPoultry':
                    # code...
                    array_push($MeatPoultry, $row);
                    break;
                case 'FishSeafood':
                    # code...
                    array_push($FishSeafood, $row);
                    break;
                case 'DairyEggs':
                    # code...
                    array_push($DairyEggs, $row);
                    break;
                case 'BeansLegumes':
                    # code...
                    array_push($BeansLegumes, $row);
                    break;
                case 'NutsSeeds':
                    # code...
                    array_push($NutsSeeds, $row);
                    break;
                case 'GrainsStarches':
                    # code...
                    array_push($GrainsStarches, $row);
                    break;
                case 'Vegetables':
                    # code...
                    array_push($Vegetables, $row);
                    break;
                case 'FruitsJuices':
                    # code...
                    array_push($FruitsJuices, $row);
                    break;
                case 'Oils':
                    # code...
                    array_push($Oils, $row);
                    break;
                case 'HerbsSpicesCondiments':
                    # code...
                    array_push($HerbsSpicesCondiments, $row);
                    break;
                case 'Beverages':
                    # code...
                    array_push($Beverages, $row);
                    break;
                
                default:
                    # code...
                    break;
            }
            
        }
        
        //$foods = "";
    	return $this->render('NoticeBoardBundle:Default:bloodFoods.html.twig', array(
            'MeatPoultry' => $MeatPoultry,  'FishSeafood' => $FishSeafood,  'DairyEggs' => $DairyEggs,  'BeansLegumes' => $BeansLegumes,  'NutsSeeds' => $NutsSeeds,  'GrainsStarches' => $GrainsStarches,  'Vegetables' => $Vegetables,  'FruitsJuices' => $FruitsJuices,  'Oils' => $Oils,  'HerbsSpicesCondiments' => $HerbsSpicesCondiments,  'Beverages' => $Beverages ));
    }

    public function addBloodTypeFoodsAction(Request $request){

        $foods = new BloodFoods();
        $statusOptions = array('Beneficial' => 'Beneficial', 'Netural' => 'Netural', 'Avoid' => 'Avoid');
        $categoryOptions = array(
            'Meat & Poultry' => 'MeatPoultry',
            'Fish & Seafood' => 'FishSeafood',
            'Dairy & Eggs' => 'DairyEggs',
            'Beans & Legumes' => 'BeansLegumes',
            'Nuts & Seeds' => 'NutsSeeds',
            'Grains & Starches' => 'GrainsStarches',
            'Vegetables' => 'Vegetables',
            'Fruits & Fruit Juices' => 'FruitsJuices',
            'Oils' => 'Oils',
            'Herbs, Spices & Condiments' => 'HerbsSpicesCondiments',
            'Beverages' => 'Beverages'
        );
        $form = $this->createFormBuilder($foods)
        ->add('cat', ChoiceType::class, array('label' => 'Food Category',
            'choices' => $categoryOptions))
        ->add('food', TextType::class)
        ->add('astatus', ChoiceType::class, array('label' =>'A Status', 'choices' => $statusOptions))
        ->add('bstatus', ChoiceType::class, array('label' =>'B Status', 'choices' => $statusOptions))
        ->add('abstatus', ChoiceType::class, array('label' =>'AB Status', 'choices' => $statusOptions))
        ->add('ostatus', ChoiceType::class, array('label' =>'O Status', 'choices' => $statusOptions))
        ->add('save', SubmitType::class, array('label' => 'Add Blood Food Type'))
        ->getForm();
        // $NoticeBoard = $repository->findAll();

        //$formBoard->handleRequest($request);
        $form->handleRequest($request);

        if($form->isSubmitted() ) //&& $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $newBloodFoods = new BloodFoods();
            $newBloodFoods->setCat($form['cat']->getData());
            $newBloodFoods->setFood($form['food']->getData());
            $newBloodFoods->setAstatus($form['astatus']->getData());
            $newBloodFoods->setBstatus($form['bstatus']->getData());
            $newBloodFoods->setABstatus($form['abstatus']->getData());
            $newBloodFoods->setOstatus($form['ostatus']->getData());
            $em->persist($newBloodFoods);
            $em->flush();
        return $this->redirect($this->get('router')->generate('bloodFoods'));
            //return $this->redirectToRoute("showNotice, {'slug:'," . $NoticeID ."}");
        }
        

        return $this->render('NoticeBoardBundle:Default:addBloodTypeFoods.html.twig', array('form' => $form->createView()
        ));
    }

    public function lynsMessageAction(){

        return $this->render('NoticeBoardBundle:Default:lynsMessage.html.twig');
    }

    public function showAboutAction()
    {
        return $this->render('NoticeBoardBundle:Default:about.html.twig');
    }

    public function categoriesNavAction()
    {
        $boards = $this->getBoardsAction();
        return $this->render('NoticeBoardBundle:Default:categoriesNav.html.twig', array('boards' => $boards));
    }

    public function addNoticeAction(Request $request)
    {

        $notice = new NoticeBoardNotices();
        // $boardsform = new NoticeBoards();
        
        $boards = $this->getAllBoardsAction();
        
        $Boards = array();
        $label = array();
        $value = array();

        for ($i=0; $i < sizeof($boards); $i++) { 
            array_push($value, $boards[$i]['title']);
            array_push($label, $boards[$i]['title']);
        }
        // array_push($value, "Add New");
        // array_push($label, "Add New");

        $Boards = array_combine($value, $label);
        // $formBoard = $this->createFormBuilder($boardsform)
        // ->add('title', TextType::class)
        // ->add('save', SubmitType::class, array('label' => 'Create Board'))
        // ->getForm();
        $boardsI18n = $this->get('translator')->trans('recipe.categories');

        $form = $this->createFormBuilder($notice)
        ->add('title', TextType::class)
        ->add('Board', ChoiceType::class, array('choices' => array($boardsI18n => $Boards)))
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
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($formBoard); //commit to temp variable
            // $em->flush(); //Commit to Database
        // }
        if($form->isSubmitted() ) //&& $form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
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
            return $this->redirect($this->get('router')->generate('showNotice', array('slug'=>$NoticeID)));
            //return $this->redirectToRoute("showNotice, {'slug:'," . $NoticeID ."}");
        }
        

        return $this->render('NoticeBoardBundle:Default:add.html.twig', array('form' => $form->createView(), 'image' => null
        ));

    }
    public function editNoticeAction($slug, Request $request)
    {

        //$data = getNoticeAction($slug);
        $repository = $this->getDoctrine()->getRepository('NoticeBoardBundle:NoticeBoardNotices');
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
    	//$notice = $this->getNoticeAction($slug);
        //$Notice = array('notice'=>$notice);
        // $boardsform = new NoticeBoards();
		
		$boards = $this->getAllBoardsAction();
		
		$Boards = array();
		$label = array();
		$value = array();

		for ($i=0; $i < sizeof($boards); $i++) { 
			array_push($value, $boards[$i]['title']);
			array_push($label, $boards[$i]['title']);
		}
		// array_push($value, "Add New");
		// array_push($label, "Add New");

		$Boards = array_combine($value, $label);
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
		->add('Board', ChoiceType::class, array('choices' => array('Boards' => $Boards)))
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
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($formBoard); //commit to temp variable
            // $em->flush(); //Commit to Database
        // }
		if($form->isSubmitted() ) //&& $form->isValid())
		{

			$em = $this->getDoctrine()->getManager();
			$newNotice = new NoticeBoardNotices();

            $file = $Notice->getImage();
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
            return $this->redirect($this->get('router')->generate('showNotice', array('slug'=>$NoticeID)));
			//return $this->redirectToRoute("showNotice, {'slug:'," . $NoticeID ."}");
		}
		

        return $this->render('NoticeBoardBundle:Default:add.html.twig', array('form' => $form->createView(), 'image' => $Notice->getImage()
        ));

    }

    public function searchAction(){
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
            $searchQuery = implode(" or ", $searchArray);
            // echo "<br>";
            // echo $searchQuery;
            
            $em = $this->getDoctrine()->getManager();
	    $query = $em->createQuery(
	      'SELECT p
            FROM NoticeBoardBundle:NoticeBoardNotices p
            WHERE ' . $searchQuery )->setParameter('query', $q );
        
	     $results = $query->getResult();
        }
        

        // echo "<br>";
        // var_dump($results);

        //$em = $this->getDoctrine()->getManager();
        ////MariaDB [test]> select * from test2 where name like "%glks%" || title like "%;%";
        //$query = $em->createQuery(
        //    'SELECT p
        //    FROM AppBundle:Product p
        //    WHERE p.price > :price
        //    ORDER BY p.price ASC'
        //)->setParameter('price', '19.99');
        //
        //$products = $query->getResult();
        // return $this->render('NoticeBoardBundle:Default:noticeListView.html.twig', array('notice' => $Notice));


        return $this->render('NoticeBoardBundle:Default:search.html.twig', array('notice' => $results, 'search' => $_GET));
    }

    //----------------------------------------------------------------------------------------------------
    //Create Functions to move to external class /file.

    //get boards
    //to get the list of boards
    public function getBoardsAction()
    {
        $repository = $this->getDoctrine()->getRepository('NoticeBoardBundle:NoticeBoards');
        $Boards     = $repository->findAll();
        return $Boards;
    }
    //get all boards
    public function getAllBoardsAction()
    {
        $Boardrepository = $this->getDoctrine()->getRepository('NoticeBoardBundle:NoticeBoards');
        $boards          = $Boardrepository->getArrayofBoards();
        return $boards;
    }
    //get notices / $board
    //to return the notices from $board
    public function getNoticesAction($board)
    {
        $em          = $this->getDoctrine()->getManager();
        $repository  = $this->getDoctrine()->getRepository('NoticeBoardBundle:NoticeBoardNotices');
        $NoticesList = $em->getRepository('NoticeBoardBundle:NoticeBoardNotices')->findBy(array('board' => $board), array('title' => 'ASC'));
        // $NoticesList = $repository->findByBoard($board);
        return $NoticesList;
    }
    public function getNoticesOrderedAction($board)
    {
        $em = $this->getDoctrine()->getManager();

        $NoticesList = $em->getRepository('NoticeBoardBundle:NoticeBoardNotices')->findBy(array('board' => $board), array('title' => 'ASC'));

        // $em          = $this->getDoctrine()->getManager();
        // $repository  = $this->getDoctrine()->getRepository('NoticeBoardBundle:NoticeBoardNotices');
        // $NoticesList = $repository->findByBoard($board);
        return $NoticesList;
    }
    
    public function getAllNotices(){
            $em = $this->getDoctrine()->getManager();

        $NoticesList = $em->getRepository('NoticeBoardBundle:NoticeBoardNotices')->findBy(array());
        //$NoticesList = $em->getRepository('NoticeBoardBundle:NoticeBoardNotices')->findBy(array('board' => $board), array('title' => 'ASC'));

    return $NoticesList;
    }
    
    //get notice ($title || $id) == $slug
    //to return the notice, either from $id or $title
    public function getNoticeAction($slug)
    {
		$repository = $this->getDoctrine()->getRepository('NoticeBoardBundle:NoticeBoardNotices');
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
    public function createBoardAction($title)
    {
    	$em = $this->getDoctrine()->getManager();
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
    public function deleteBoardAction($slug)
    {
    	$em = $this->getDoctrine()->getManager();
    	$em->remove($slug);
		$em->flush();
        return "test";
    }
    //create notice $data
    //to create a notice with title, board, req, etc
    public function createNoticeAction($data)
    {
    	$notice = new NoticeBoardNotices();
    	$boards = $this->getAllBoardsAction();
        return "test";
    }
    //delete notice / ($title || $id) == $slug
    //to delete notice known by $id or $title
    public function deleteNoticeAction($slug)
    {
        return "test";
    }

}
