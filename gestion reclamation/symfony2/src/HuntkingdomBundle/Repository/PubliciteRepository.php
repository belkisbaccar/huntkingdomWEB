<?php

namespace HuntkingdomBundle\Repository;

/**
 * PubliciteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PubliciteRepository extends \Doctrine\ORM\EntityRepository
{
    public function findPubAimer($id,$user)
    {
        $query=$this->getEntityManager()->createQuery("SELECT i FROM HuntkingdomBundle:PubliciteAimer i 
WHERE i.idPublicite=$id AND i.idUser= $user");
        return $query->getResult();
    }
    public function  findIDS1(){

    }

}