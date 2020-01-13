<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Repositories\Issues;

use Bitbucket\API;
use Buzz\Message\MessageInterface;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class Comments extends API\Api
{
    /**
     * Get all comments for specified issue
     *
     * Comments are returned in DESC order by posted date.
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $issueID The issue identifier.
     * @return MessageInterface
     */
    public function all($account, $repo, $issueID)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/issues/%d/comments', $account, $repo, $issueID)
        );
    }

    /**
     * Get an individual comment for specified issue
     *
     * @access public
     * @param  string           $account   The team or individual account owning the repository.
     * @param  string           $repo      The repository identifier.
     * @param  int              $issueID   The issue identifier.
     * @param  int              $commentID The comment identifier.
     * @return MessageInterface
     */
    public function get($account, $repo, $issueID, $commentID)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/issues/%d/comments/%d', $account, $repo, $issueID, $commentID)
        );
    }

    /**
     * Add a new comment to specified issue
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $issueID The issue identifier.
     * @param  string           $content The comment.
     * @return MessageInterface
     */
    public function create($account, $repo, $issueID, $content)
    {
        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/issues/%d/comments', $account, $repo, $issueID),
            array('content' => $content)
        );
    }

    /**
     * Update an existing comment to specified issue
     *
     * @access public
     * @param  string           $account   The team or individual account owning the repository.
     * @param  string           $repo      The repository identifier.
     * @param  int              $issueID   The issue identifier.
     * @param  string           $content   The comment.
     * @param  int              $commentID The comment identifier.
     * @return MessageInterface
     */
    public function update($account, $repo, $issueID, $commentID, $content)
    {
        return $this->getClient()->setApiVersion('2.0')->put(
            sprintf('/repositories/%s/%s/issues/%d/comments/%d', $account, $repo, $issueID, $commentID),
            array('content' => $content)
        );
    }
}
