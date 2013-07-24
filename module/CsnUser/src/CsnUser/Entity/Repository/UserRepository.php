<?php
namespace CsnUser\Entity\Repository;

use Doctrine\ORM\EntityRepository;

// before called Table now Repository Table Data Gateway
// In Bug Entity add  @Entity(repositoryClass="BugRepository")
// To be able to use this query logic through 
// $this->getEntityManager()->getRepository('Bug') we have to adjust the metadata slightly.
// http://stackoverflow.com/questions/10481916/the-method-name-must-start-with-either-findby-or-findoneby-uncaught-exception

class UserRepository extends EntityRepository
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