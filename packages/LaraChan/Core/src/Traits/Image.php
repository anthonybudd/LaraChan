<?php
namespace LaraChan\Core\Traits;

trait Image
{
    public function hasImage()
    {
        return !is_null($this->image);
    }

    public function fileName()
    {
        return basename($this->image);
    }
}
