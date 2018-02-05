<?php

namespace NoticeBoardBundle\Entity;

/**
 * BloodFoods
 */
class BloodFoods
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $cat;

    /**
     * @var string
     */
    private $food;

    /**
     * @var string
     */
    private $astatus;

    /**
     * @var string
     */
    private $bstatus;

    /**
     * @var string
     */
    private $aBstatus;

    /**
     * @var string
     */
    private $ostatus;


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
     * Set cat
     *
     * @param string $cat
     *
     * @return BloodFoods
     */
    public function setCat($cat)
    {
        $this->cat = $cat;

        return $this;
    }

    /**
     * Get cat
     *
     * @return string
     */
    public function getCat()
    {
        return $this->cat;
    }

    /**
     * Set food
     *
     * @param string $food
     *
     * @return BloodFoods
     */
    public function setFood($food)
    {
        $this->food = $food;

        return $this;
    }

    /**
     * Get food
     *
     * @return string
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * Set astatus
     *
     * @param string $astatus
     *
     * @return BloodFoods
     */
    public function setAstatus($astatus)
    {
        $this->astatus = $astatus;

        return $this;
    }

    /**
     * Get astatus
     *
     * @return string
     */
    public function getAstatus()
    {
        return $this->astatus;
    }

    /**
     * Set bstatus
     *
     * @param string $bstatus
     *
     * @return BloodFoods
     */
    public function setBstatus($bstatus)
    {
        $this->bstatus = $bstatus;

        return $this;
    }

    /**
     * Get bstatus
     *
     * @return string
     */
    public function getBstatus()
    {
        return $this->bstatus;
    }

    /**
     * Set aBstatus
     *
     * @param string $aBstatus
     *
     * @return BloodFoods
     */
    public function setABstatus($aBstatus)
    {
        $this->aBstatus = $aBstatus;

        return $this;
    }

    /**
     * Get aBstatus
     *
     * @return string
     */
    public function getABstatus()
    {
        return $this->aBstatus;
    }

    /**
     * Set ostatus
     *
     * @param string $ostatus
     *
     * @return BloodFoods
     */
    public function setOstatus($ostatus)
    {
        $this->ostatus = $ostatus;

        return $this;
    }

    /**
     * Get ostatus
     *
     * @return string
     */
    public function getOstatus()
    {
        return $this->ostatus;
    }
}

