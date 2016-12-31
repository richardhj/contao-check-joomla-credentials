<?php


/**
 * Class CheckJoomlaCredentials
 */
class CheckJoomlaCredentials
{
    /**
     * @param string $username
     * @param string $password
     * @param \User  $user
     *
     * @return bool
     */
    public function checkLegacyJoomlaCredentials($username, $password, \User $user)
    {
        list($legacyPasswordHash, $legacyPasswordSalt) = explode(':', $user->password);

        // Check if password matches
        if ($legacyPasswordHash !== md5($password.$legacyPasswordSalt)) {
            return false;
        }

        // Update password hash in database
        $user->password = \Encryption::hash($password);
        $user->save();

        return true;
    }
}
