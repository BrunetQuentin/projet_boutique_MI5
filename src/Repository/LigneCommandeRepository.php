<?php

namespace App\Repository;

use App\Entity\LigneCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneCommande>
 *
 * @method LigneCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneCommande[]    findAll()
 * @method LigneCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneCommandeRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, LigneCommande::class);
  }

  public function save(LigneCommande $entity, bool $flush = false): void
  {
    $this->getEntityManager()->persist($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  public function remove(LigneCommande $entity, bool $flush = false): void
  {
    $this->getEntityManager()->remove($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  public function findBestSeller($nbr = 5): array
  {
    return $this->createQueryBuilder('l')
      ->select(
        'c.id as idCategorie, p.id, p.visuel, p.texte, SUM(l.quantite) as quantite'
      )
      ->join('l.article', 'p')
      ->join('p.categorie', 'c')
      ->groupBy('p.id')
      ->orderBy('quantite', 'DESC')
      ->setMaxResults($nbr)
      ->getQuery()
      ->getResult();
  }

  public function create($article, $quantite, $commande)
  {
    $ligneCommande = new LigneCommande();
    $ligneCommande->setArticle($article);
    $ligneCommande->setQuantite($quantite);
    $ligneCommande->setCommande($commande);
    $ligneCommande->setPrix($article->getPrix());

    $this->save($ligneCommande, true);
    return $ligneCommande;
  }

  //    /**
  //     * @return LigneCommande[] Returns an array of LigneCommande objects
  //     */
  //    public function findByExampleField($value): array
  //    {
  //        return $this->createQueryBuilder('l')
  //            ->andWhere('l.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->orderBy('l.id', 'ASC')
  //            ->setMaxResults(10)
  //            ->getQuery()
  //            ->getResult()
  //        ;
  //    }

  //    public function findOneBySomeField($value): ?LigneCommande
  //    {
  //        return $this->createQueryBuilder('l')
  //            ->andWhere('l.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->getQuery()
  //            ->getOneOrNullResult()
  //        ;
  //    }
}
