<?php
namespace CsnCms\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function getRolesArray($number = 30)
    {
//        $dql = "SELECT b, e, r, p FROM \GraceDrops\Entity\User b JOIN b.engineer e ".
//               "JOIN b.reporter r JOIN b.products p ORDER BY b.created DESC";
//        $query = $this->getEntityManager()->createQuery($dql);
//        $query->setMaxResults($number);
//        return $query->getArrayResult();
		return array();
    }
	
    public function getArticleForEdit($artcId)
    {
//        $dql = "SELECT b, e, r FROM \Application\Entity\Bug b JOIN b.engineer e JOIN b.reporter r ".
//               "WHERE b.status = 'OPEN' AND e.id = ?1 OR r.id = ?1 ORDER BY b.created DESC";
		$dql = "SELECT a, u, l, c, p, r FROM CsnCms\Entity\Article a LEFT JOIN a.author u LEFT JOIN a.language l LEFT JOIN a.categories c LEFT JOIN a.parent p LEFT JOIN a.resource r WHERE a.artcId = ?1"; 
		
        $articles = $this->getEntityManager()->createQuery($dql)
                             ->setParameter(1, $artcId)
//                             ->setMaxResults($number)
                             ->getResult();
							 // ->getScalarResult();
							 // ->getArrayResult();
		return $articles[0];
    }

/*	
    public function getArticleForEdit($artcId)
    {
//        $dql = "SELECT b, e, r FROM \Application\Entity\Bug b JOIN b.engineer e JOIN b.reporter r ".
//               "WHERE b.status = 'OPEN' AND e.id = ?1 OR r.id = ?1 ORDER BY b.created DESC";
		$dql = "SELECT a, u, l, c, p, r FROM GraceDrops\Entity\Article a LEFT JOIN a.author u LEFT JOIN a.language l LEFT JOIN a.categories c LEFT JOIN a.parent p LEFT JOIN a.resource r WHERE a.artcId = ?1"; 
		
        $articles = $this->getEntityManager()->createQuery($dql)
                             ->setParameter(1, $artcId)
//                             ->setMaxResults($number)
                             ->getResult();
							 // ->getScalarResult();
							 // ->getArrayResult();
		return $articles[0];
    }
*/
	//  There are already findBy or findOneBy!
/*
    public function getRecentBugs($number = 30)
    {
        $dql = "SELECT b, e, r FROM \Application\Entity\Bug b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($number);
        return $query->getResult();
    }

	//  findBy or findOneBy!
    public function findByRecentBugs($number = 30)
    {
        $dql = "SELECT b, e, r FROM \Application\Entity\Bug b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($number);
        return $query->getResult();
    }
	
    public function getRecentBugsArray($number = 30)
    {
        $dql = "SELECT b, e, r, p FROM \Application\Entity\Bug b JOIN b.engineer e ".
               "JOIN b.reporter r JOIN b.products p ORDER BY b.created DESC";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($number);
        return $query->getArrayResult();
    }

    public function getUsersBugs($userId, $number = 15)
    {
        $dql = "SELECT b, e, r FROM \Application\Entity\Bug b JOIN b.engineer e JOIN b.reporter r ".
               "WHERE b.status = 'OPEN' AND e.id = ?1 OR r.id = ?1 ORDER BY b.created DESC";

        return $this->getEntityManager()->createQuery($dql)
                             ->setParameter(1, $userId)
                             ->setMaxResults($number)
                             ->getResult();
    }

    public function getOpenBugsByProduct()
    {
        $dql = "SELECT p.id, p.name, count(b.id) AS openBugs FROM \Application\Entity\Bug b ".
               "JOIN b.products p WHERE b.status = 'OPEN' GROUP BY p.id";
        return $this->getEntityManager()->createQuery($dql)->getScalarResult();
    }
*/
}

/*
// Fatal error: Uncaught exception 'BadMethodCallException' with message 'Undefined
 method 'getRecentBugs'. The method name must start with either findBy or findOn
eBy!' in H:\xampp\php\pear\Doctrine\ORM\EntityRepository.php on line 196
*/