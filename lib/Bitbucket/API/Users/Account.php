<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Users;

use Bitbucket\API\Api;
use Buzz\Message\MessageInterface;

/**
 * This resource returns a user structure and the repositories array associated
 * with an existing account.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class Account extends Api
{
    /**
     * Get the account profile
     *
     * @access public
     * @param  string           $account The name of an individual or team account, or validated email address.
     * @return MessageInterface
     */
    public function profile($account)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/users/%s', $account)
        );
    }

    /**
     * Get the followers
     *
     * Gets a count and the list of accounts following an account.
     *
     * @access public
     * @param  string           $account The name of an individual or team account, or validated email address.
     * @return MessageInterface
     */
    public function followers($account)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/users/%s/followers', $account)
        );
    }
}
