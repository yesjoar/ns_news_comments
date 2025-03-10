<?php
namespace Nitsan\NsNewsComments\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The repository for Comments
 */
class CommentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     *
     * @param $newsId
     */
    public function getCommentsByNews($newsId)
    {
        $query = $this->createQuery();
        $queryArr = array();
        $queryArr = array(
            $query->equals('newsuid', $newsId),
            $query->equals('comment', 0),
        );
        $query->matching($query->logicalAnd($queryArr));
        $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
        $result = $query->execute();
        return $result;
    }

    /**
     *
     * @param $newsId
     */
    public function getCommentsByAccesstoken($accesstoken)
    {
        $query = $this->createQuery();
        $queryArr = array();
        $queryArr = array(
            $query->equals('accesstoken', $accesstoken),
        );

        // Here you enable the hidden and deleted Records
        $query->getQuerySettings()
            ->setIgnoreEnableFields(true);

        $query->matching($query->logicalAnd($queryArr));
        $result = $query->execute();
        return $result;
    }

    /**
     *
     * @param $newsId
     */
    public function getLastCommentOfNews($newsuid = null)
    {
        $query = $this->createQuery();
        $queryArr = array();
        $queryArr = array(
            $query->equals('newsuid', $newsuid),
        );
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->logicalAnd($queryArr));
        $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
        $result = $query->setLimit(1)->execute();
        return $result;
    }
}
