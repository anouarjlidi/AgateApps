<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DisciplinesDomains
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\DisciplinesDomainsRepository")
 * @ORM\Table(name="disciplines_domains",uniqueConstraints={@ORM\UniqueConstraint(name="idcdUnique", columns={"disciplines_id", "domains_id"})})
 */
class DisciplinesDomains
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Disciplines
     *
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Disciplines")
     *
     * @ORM\Column(name="disciplines_id", type="integer")
     */
    protected $discipline;

    /**
     * @var \Domains
     *
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Domains")
     * @ORM\Column(name="domains_id", type="integer")
     */
    protected $domain;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
     */
    protected $deleted;

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
     * Set discipline
     *
     * @param integer $discipline
     * @return DisciplinesDomains
     */
    public function setDiscipline($discipline)
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * Get discipline
     *
     * @return integer
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * Set domain
     *
     * @param integer $domain
     * @return DisciplinesDomains
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return integer
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
