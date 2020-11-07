<?php

class UserView extends UserModel
{
    public function displayUser()
    {
        return $this->fetchUser();
    }

    public function displayAllUsers()
    {
        return $this->fetchAllUsers();
    }

    public function displayUsersAjax()
    {
        return $this->fetchUserAjax();
    }
}
