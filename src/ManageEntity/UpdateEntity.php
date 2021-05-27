<?php


namespace App\ManageEntity;


use Doctrine\ORM\EntityManagerInterface;

class UpdateEntity
{

    private $entityManger;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManger = $entityManager;
    }

    public function save($entity)
    {
        $this->entityManger->persist($entity);
        $this->entityManger->flush();
    }

    public function delete($entity){
        $this->entityManger->remove($entity);
        $this->entityManger->flush();
    }

}