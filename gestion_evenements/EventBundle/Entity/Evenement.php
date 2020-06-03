<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @return
     */
    public function getTitreEvent()
    {
        return $this->titreEvent;
    }

    /**
     * @param string $titreEvent
     */
    public function setTitreEvent($titreEvent)
    {
        $this->titreEvent = $titreEvent;
    }

    /**
     * @return
     */
    public function getDescriptionEvent()
    {
        return $this->descriptionEvent;
    }

    /**
     * @param string $descriptionEvent
     */
    public function setDescriptionEvent($descriptionEvent)
    {
        $this->descriptionEvent = $descriptionEvent;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function getWebPatch(){
        return null===$this->image ? null : $this->getUploadDir().'/'.$this->image;
    }
    protected function getUploadRootDir(){
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir(){
        return 'imagesEvent';
    }
    public function uploadPubimage(){
        if($this->file ===null)
        {
            return;
        }
        else {
            $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
            $this->image = $this->file->getClientOriginalName();
            $this->file = null;

        }
    }

    /**
     * @return \Date
     */
    public function getDateDebutEvent()
    {
        return $this->dateDebutEvent;
    }

    /**
     * @param \Date $dateDebutEvent
     */
    public function setDateDebutEvent($dateDebutEvent)
    {
        $this->dateDebutEvent = $dateDebutEvent;
    }

    /**
     * @return \Date
     */
    public function getDateFinEvent()
    {
        return $this->dateFinEvent;
    }

    /**
     * @param \Date $dateFinEvent
     */
    public function setDateFinEvent($dateFinEvent)
    {
        $this->dateFinEvent = $dateFinEvent;
    }

    /**
     * @return int
     */
    public function getNbPlaceEvent()
    {
        return $this->nbPlaceEvent;
    }

    /**
     * @param int $nbPlaceEvent
     */
    public function setNbPlaceEvent($nbPlaceEvent)
    {
        $this->nbPlaceEvent = $nbPlaceEvent;
    }
    /**
     * @return int
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * @param int $idEvent
     */
    public function setIdEvent($idEvent)
    {
        $this->idEvent = $idEvent;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id_event", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_event", type="string", length=50, nullable=false)
     */
    private $titreEvent;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="idUser"  ,referencedColumnName="id", onDelete="CASCADE")
     */
    private $idUser;
    /**
     * @var string
     *
     * @ORM\Column(name="description_event", type="string", length=255, nullable=false)
     */
    private $descriptionEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;
    /**
     * @Assert\File(maxSize="1000k")
     */
    public $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut_event", type="date", nullable=false)
     */
    private $dateDebutEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_event", type="date", nullable=false)
     */
    private $dateFinEvent;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_place_event", type="integer", nullable=false)
     */
    private $nbPlaceEvent;
    /**
     * @var integer
     *
     * @ORM\Column(name="nb", type="integer", nullable=false)
     */
    private $nb;
    /**
     * @var integer
     *
     * @ORM\Column(name="$idUserr", type="integer", nullable=false)
     */
    private $idUserr;
    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * Set nb
     *
     * @param integer $nb
     *
     * @return Evenement
     */
    public function setNb($nb)
    {
        $this->nb = $nb;

        return $this;
    }

    /**
     * Get nb
     *
     * @return integer
     */
    public function getNb()
    {
        return $this->nb;
    }

    /**
     * Set idUser
     *
     * @param \UserBundle\Entity\User $idUser
     *
     * @return Evenement
     */
    public function setIdUser(\UserBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idUserr
     *
     * @param integer $idUserr
     *
     * @return Evenement
     */
    public function setIdUserr($idUserr)
    {
        $this->idUserr = $idUserr;

        return $this;
    }

    /**
     * Get idUserr
     *
     * @return integer
     */
    public function getIdUserr()
    {
        return $this->idUserr;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Evenement
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }
}
