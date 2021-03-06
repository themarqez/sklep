<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Review
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Opinion", type="text")
     */
    private $opinion;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="reviews")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     **/
    private $movie;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set opinion
     *
     * @param string $opinion
     * @return Review
     */
    public function setOpinion($opinion)
    {
        $this->opinion = $opinion;

        return $this;
    }

    /**
     * Get opinion
     *
     * @return string 
     */
    public function getOpinion()
    {
        return $this->opinion;
    }

    /**
     * Set movie
     *
     * @param \AppBundle\Entity\Movie $movie
     * @return Review
     */
    public function setMovie(\AppBundle\Entity\Movie $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return \AppBundle\Entity\Movie 
     */
    public function getMovie()
    {
        return $this->movie;
    }
}
