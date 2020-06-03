<?php

namespace HuntkingdomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PubliciteAimer
 *
 * @ORM\Table(name="publicite_aimer")
 * @ORM\Entity
 */
class PubliciteAimer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_pub_aimer", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPubAimer;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_publicite", type="integer", nullable=false)
     */
    private $idPublicite;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="HuntkingdomBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @return int
     */
    public function getIdPubAimer()
    {
        return $this->idPubAimer;
    }

    /**
     * @param int $idPubAimer
     */
    public function setIdPubAimer($idPubAimer)
    {
        $this->idPubAimer = $idPubAimer;
    }

    /**
     * @return int
     */
    public function getIdPublicite()
    {
        return $this->idPublicite;
    }

    /**
     * @param int $idPublicite
     */
    public function setIdPublicite($idPublicite)
    {
        $this->idPublicite = $idPublicite;
    }

    /**
     * @return User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param User $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }



    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


}

