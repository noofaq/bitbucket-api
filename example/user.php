<?php

require_once __DIR__.'/../vendor/autoload.php';

$user = new Bitbucket\API\User;

// Your Bitbucket credentials
$bb_user = 'username';
$bb_pass = 'password';

/**
 * $accountname The team or individual account owning the repository.
 * repo_slub    The repository identifier.
 */
$accountname    = 'company';
$repo_slug      = 'sandbox';


// login
$user->setCredentials( new Bitbucket\API\Authentication\Basic($bb_user, $bb_pass) );

# get user profile
# print_r($user->get());
