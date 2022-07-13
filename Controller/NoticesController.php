<?php

namespace App\NoticeBoardBundle\Controller;

use App\NoticeBoardBundle\Entity\NoticeBoardNotices;
use App\NoticeBoardBundle\Entity\NoticeBoards;
use Symfony\Component\BrowserKit\Response;	
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class NoticesController
{
	public function TestEcho(){

		echo "test";
	}
	public function GetBoards(){
		$repository = $this->getDoctrine() ->getRepository('NoticeBoardBundle:NoticeBoards');
		$NoticeBoards = $repository->findAll();
			
		return $NoticeBoards;
	}
}