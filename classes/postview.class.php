<?php

class PostView extends PostModel
{
    public static $no_post_in_cate_msg = "Sorry, there are not post in this category";

    public function displayAllPosts()
    {
        return $this->fetchAllPosts();
    }

    public function displayPostPerPage()
    {
        return $this->fetchPostPerPage();
    }

    public function displaySearchResult()
    {
        return $this->fetchSearchResult();
    }

    public function displayCatePost()
    {
        return $this->fetchPostsFromCate();
    }

    public function displayAuthorPost()
    {
        return $this->fetchPostFromAuthor();
    }

    public function displayPost()
    {
        return $this->fetchPost();
    }

    public function displayPagination()
    {
        return $this->fetchPostCount();
    }
}
