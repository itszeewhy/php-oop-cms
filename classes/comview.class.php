<?php

class ComView extends ComModel
{
    public function displayComment()
    {
        return $this->fetchComment();
    }

    public function displayAllComments()
    {
        return $this->fetchAllComments();
    }

    public function displayPostCommentCount()
    {
        return $this->fetchPostCommentCount();
    }

    public function displayPostComments()
    {
        return $this->fetchPostComments();
    }
}
