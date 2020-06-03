<?php

namespace HuntkingdomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="id_produit", columns={"id_produit"}), @ORM\Index(name="id_annonce_reclame", columns={"id_annonce_reclame"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_reclamation", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=25, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date = 'current_timestamp()';

    /**
     * @var \HuntkingdomBundle\Entity\Annonce
     *
     * @ORM\ManyToOne(targetEntity="HuntkingdomBundle\Entity\Annonce")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_annonce_reclame", referencedColumnName="id_annonce")
     * })
     */
    private $idAnnonceReclame;

    /**
     * @var \HuntkingdomBundle\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="HuntkingdomBundle\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="ID")
     * })
     */
    private $idProduit;
    /**
     * @Assert\File(maxSize="500k")
     *
     */
    private $file;


    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     */
    private $priority;
    /**
     * @return int
     */
    public function getIdReclamation()
    {
        return $this->idReclamation;
    }

    /**
     * @param int $idReclamation
     */
    public function setIdReclamation($idReclamation)
    {
        $this->idReclamation = $idReclamation;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
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



    /**
     * @return Annonce
     */
    public function getIdAnnonceReclame()
    {
        return $this->idAnnonceReclame;
    }

    /**
     * @param Annonce $idAnnonceReclame
     */
    public function setIdAnnonceReclame(Annonce $idAnnonceReclame)
    {
        $this->idAnnonceReclame = $idAnnonceReclame;
    }

    /**
     * @return Product
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param Product $idProduit
     */
    public function setIdProduit(Product $idProduit)
    {
        $this->idProduit = $idProduit;
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
    public function setIdUser(User $idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }



    /**
     * @var \HuntkingdomBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="HuntkingdomBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function setFile($file)
    {
        $this->file = $file;
    }
    public function getWebPAth(){
        return null===$this->image ? null : $this->getUploadDir.'/'.$this->image;
    }
    protected function getUploadRootDir(){
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir(){
        return 'images';
    }
    public function uploadPicture(){
        if($this->file != null){
            $this->file->move($this->getUploadRootDir(),$this->file->getClientOriginalName());
            $this->image=$this->file->getClientOriginalName();
            $this->file=null;
        }
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }




}

