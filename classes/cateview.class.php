<?php

class CateView extends CateModel
{
    public function displayAllCate()
    {
        return $this->fetchAllCate();
    }

    public function displayEditingCate()
    {
        echo $this->fetchEditingCate();
    }
}
