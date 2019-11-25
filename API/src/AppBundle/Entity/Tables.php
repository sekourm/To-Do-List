<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tables
 *
 * @ORM\Table(name="tables")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TablesRepository")
 */
class Tables
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="action", type="string")
     */
    private $action;

    /**
     * @ORM\Column(name="champ_oblig", type="integer")
     */
    private $champ_oblig;


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
     * Set name
     *
     * @param string $name
     * @return Tables
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set champ_oblig
     *
     * @param \int $champOblig
     * @return Tables
     */
    public function setChampOblig(\integer $champOblig)
    {
        $this->champ_oblig = $champOblig;

        return $this;
    }

    /**
     * Get champ_oblig
     *
     * @return \int 
     */
    public function getChampOblig()
    {
        return $this->champ_oblig;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return Tables
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }
}
