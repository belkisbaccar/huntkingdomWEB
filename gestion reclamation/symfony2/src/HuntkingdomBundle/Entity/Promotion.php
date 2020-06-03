<?php

namespace HuntkingdomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *@ORM\Entity(repositoryClass="\HuntkingdomBundle\Repository\PromotionRepository")
 * @ORM\Table(name="promotion")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Promotion
{

    /**
     * @return float
     */
    public function getTaux()
    {
        return $this->taux;
    }

    /**
     * @param float $taux
     */
    public function setTaux($taux)
    {
        $this->taux = $taux;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }
    /**
     * @return int
     */
    public function getIdPromotion()
    {
        return $this->idPromotion;
    }

    /**
     * @param int $idPromotion
     */
    public function setIdPromotion($idPromotion)
    {
        $this->idPromotion = $idPromotion;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id_promotion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPromotion;



    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="id_produit",referencedColumnName="ID")
     */
    private  $Product;


    /**
     * @var float
     *
     * @ORM\Column(name="taux", type="float", precision=10, scale=0, nullable=false)
     */
    private $taux;

    /**
     * @var integer
     *
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @return mixed
     */
    public function getProduct ()
    {
        return $this->Product;
    }

    /**
     * @param mixed $Product
     */
    public function setProduct ($Product)
    {
        $this->Product = $Product;
    }



}
