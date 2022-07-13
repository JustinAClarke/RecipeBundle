<?php

namespace App\NoticeBoardBundle\Entity;

/**
 * NoticeBoardNotices
 */
class NoticeBoardNotices
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $board;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $requirements;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $servs;

    /**
     * @var string
     */
    private $prep;

    /**
     * @var string
     */
    private $cook;

    /**
     * @var string
     */
    private $dateinit;

    /**
     * @var string
     */
    private $datemod;

    /**
     * @var string
     */
    private $userinit;

    /**
     * @var string
     */
    private $usermod;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set board
     *
     * @param string $board
     *
     * @return NoticeBoardNotices
     */
    public function setBoard($board)
    {
        $this->board = $board;

        return $this;
    }

    /**
     * Get board
     *
     * @return string
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return NoticeBoardNotices
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set requirements
     *
     * @param string $requirements
     *
     * @return NoticeBoardNotices
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;

        return $this;
    }

    /**
     * Get requirements
     *
     * @return string
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return NoticeBoardNotices
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return NoticeBoardNotices
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Get Title&ID
     *
     * @return array
     */
    public function getTitleID()
    {
        
        return array('id' => $this->id, 'title' => $this->title);
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return NoticeBoardNotices
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    public function __toString()
    {
        return $this->title;
    }
}


