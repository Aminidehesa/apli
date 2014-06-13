<?php
namespace Cupon\CiudadBundle\Entity;
use Doctrine\ORM\EntityRepository;

class CiudadRepository extends EntityRepository
{
    public function findCercanas($ciudad_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
        SELECT c
        FROM CiudadBundle:Ciudad c
        WHERE c.id != :id
        ORDER BY c.nombre ASC');
        $consulta->setMaxResults(5);
        $consulta->setParameter('id', $ciudad_id);
        return $consulta->getResult();
    }
    public function findRecientes($ciudad_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o, t
            FROM OfertaBundle:Oferta o
            JOIN o.tienda t
            WHERE o.revisada = true
            AND o.fechaPublicacion < :fecha
            AND o.ciudad = :id
            ORDER BY o.fechaPublicacion DESC');
        $consulta->setMaxResults(5);
        $consulta->setParameter('id', $ciudad_id);
        $consulta->setParameter('fecha', new \DateTime('today'));
        return $consulta->getResult();
    }

}


