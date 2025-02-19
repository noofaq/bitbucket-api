<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Repositories;

use Bitbucket\API\Api;
use Psr\Http\Message\ResponseInterface;

/**
 * Manage branch restrictions on a repository
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class BranchRestrictions extends Api
{
    /**
     * Allowed restrictions to create a new branch permission for
     * @var array
     */
    protected $allowedRestrictionTypes = array(
        'require_tasks_to_be_completed',
        'require_passing_builds_to_merge',
        'force',
        'require_all_dependencies_merged',
        'push',
        'require_approvals_to_merge',
        'enforce_merge_checks',
        'restrict_merges',
        'reset_pullrequest_approvals_on_change',
        'delete'
    );

    /**
     * Get the information associated with a repository's branch restrictions
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @return ResponseInterface
     */
    public function all($account, $repo)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/branch-restrictions', $account, $repo)
        );
    }

    /**
     * Creates restrictions for the specified repository.
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  array|string     $params  Additional parameters as array or JSON string
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function create($account, $repo, $params = array())
    {
        $defaults = array(
            'kind' => 'push'
        );

        // allow developer to directly specify params as json if (s)he wants.
        if ('array' !== gettype($params)) {
            if (empty($params)) {
                throw new \InvalidArgumentException('Invalid JSON provided.');
            }

            $params = $this->decodeJSON($params);
        }

        $params = array_merge($defaults, $params);

        if (empty($params['kind']) || !in_array($params['kind'], $this->allowedRestrictionTypes)) {
            throw new \InvalidArgumentException('Invalid restriction kind.');
        }

        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/branch-restrictions', $account, $repo),
            json_encode($params),
            array('Content-Type' => 'application/json')
        );
    }

    /**
     * Get a specific restriction
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      The restriction's identifier.
     * @return ResponseInterface
     */
    public function get($account, $repo, $id)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/branch-restrictions/%d', $account, $repo, $id)
        );
    }

    /**
     * Updates a specific branch restriction.
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      The restriction's identifier.
     * @param  array|string     $params  Additional parameters as array or JSON string
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function update($account, $repo, $id, $params = array())
    {
        // allow developer to directly specify params as json if (s)he wants.
        if ('array' !== gettype($params)) {
            if (empty($params)) {
                throw new \InvalidArgumentException('Invalid JSON provided.');
            }

            $params = $this->decodeJSON($params);
        }

        if (!empty($params['kind'])) {
            throw new \InvalidArgumentException('You cannot change the "kind" value.');
        }

        return $this->getClient()->setApiVersion('2.0')->put(
            sprintf('/repositories/%s/%s/branch-restrictions/%d', $account, $repo, $id),
            json_encode($params),
            array('Content-Type' => 'application/json')
        );
    }

    /**
     * Delete a specific branch restriction.
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      The restriction's identifier.
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function delete($account, $repo, $id)
    {
        return $this->getClient()->setApiVersion('2.0')->delete(
            sprintf('/repositories/%s/%s/branch-restrictions/%d', $account, $repo, $id)
        );
    }

    /**
     * Add allowed permission types
     *
     * @param array $restrictions
     */
    public function addAllowedRestrictionType($restrictions = array())
    {
        $this->allowedRestrictionTypes = array_merge($this->allowedRestrictionTypes, $restrictions);
    }
}
