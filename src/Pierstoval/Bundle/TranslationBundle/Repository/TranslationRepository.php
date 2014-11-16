<?php
namespace Pierstoval\Bundle\TranslationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Pierstoval\Bundle\TranslationBundle\Entity\Translation;

/**
 * TranslationRepository
 *
 */
class TranslationRepository extends EntityRepository {

    public function findByTokens($tokens = array()) {
        return $this->findBy(array('token' => $tokens));
    }

    public function getDomains()
    {
        $dql = 'SELECT o.domain as domain FROM Pierstoval\Bundle\TranslationBundle\Entity\Translation o GROUP BY o.domain';

        $query = $this->_em->createQuery($dql);

        $result = $query->getResult();
        foreach ($result as $k => $v) {
            $result[$k] = $v['domain'];
        }

        return $result;
    }

    public function getLocales()
    {
        $dql = 'SELECT o.locale as locale FROM Pierstoval\Bundle\TranslationBundle\Entity\Translation o GROUP BY o.locale';

        $query = $this->_em->createQuery($dql);

        $result = $query->getResult();
        foreach ($result as $k => $v) {
            $result[$k] = $v['locale'];
        }

        return $result;
    }

    public function findOneLikes(Translation $translation)
    {
        $em = $this->_em;
        $dql = "
        SELECT translationsLike
        FROM PierstovalTranslationBundle:Translation translationsLike
        WHERE
               translationsLike.source LIKE concat('%',:source,'%')
            OR translationsLike.translation LIKE concat('%',:source,'%')
        ";

        $params = array('source' => $translation->getSource());

        if ($translation->getTranslation()) {
            $dql .= "
            OR translationsLike.source LIKE concat('%',:trans,'%')
            OR translationsLike.translation LIKE concat('%',:trans,'%')
            ";
            $params['trans'] = $translation->getTranslation();
        }

        $dql .= " ORDER BY translationsLike.domain ASC, translationsLike.source ASC";

        $query = $em->createQuery($dql);
        $query->setParameters($params);

        return $query->getResult();
    }

    /**
     * @param null|string $locale
     * @param null|string $domain
     * @return array
     */
    public function findLikes($locale = null, $domain = null) {

        $em = $this->_em;
        $dql = "
        SELECT t1, translationsLike
            FROM PierstovalTranslationBundle:Translation t1
            LEFT JOIN PierstovalTranslationBundle:Translation translationsLike
                WITH
                    (
                        t1.source LIKE concat('%',translationsLike.source,'%')
                        OR t1.source LIKE concat('%',translationsLike.translation,'%')
                    ) and (
                        t1.locale != translationsLike.locale
                        OR (
                            t1.locale = translationsLike.locale
                            AND t1.source != translationsLike.source
                        )
                    )
        ";

        $params = array();

        if ($locale || $domain) {
            $dql .= " WHERE ";
            if ($locale) {
                $dql .= ' t1.locale = :locale ';
                $params[':locale'] = $locale;
            }
            if ($domain) {
                if ($locale) { $dql .= " AND "; }
                $dql .= " t1.domain = :domain ";
                $params[':domain'] = $domain;
            }
        }

        $dql .= "
            ORDER BY t1.domain ASC, t1.source ASC
        ";

        $config = $em->getConfiguration();
        $config->addCustomHydrationMode('translation_like', 'Pierstoval\Bundle\TranslationBundle\Doctrine\TranslationLikeHydrator');

        $query = $em->createQuery($dql);

        $query->setParameters($params);

        return $query->getResult('translation_like');
    }
}
