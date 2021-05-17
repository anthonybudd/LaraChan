<?php

namespace LaraChan\Core\Traits;

use LaraChan\Core\Models\Thread;
use LaraChan\Core\Models\Reply;

trait Renderable
{
    public function render()
    {
        if ($this instanceof Thread) {
            $text = $this->body;
        } elseif ($this instanceof Reply) {
            $text = $this->comment;
        }else{
            throw new \Exception("The Renderable trait can only be applied to Thread or Reply");
        }
        
        $lines = explode(PHP_EOL, $text);
        foreach($lines as $i => $line) {
            if (str_starts_with($line, '>>')) {
                preg_match('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', $line, $matches);
                if (count($matches) > 0) {
                    $lines[$i] = '<a href="#'. $matches[0] .'">'.$line.'</a>'; 
                }
            } elseif (str_starts_with($line, '>')) {
                $lines[$i] = '<span style="color:#789922">'.$line.'</span>';
            } elseif (str_starts_with($line, '#')) {
                $lines[$i] = '<span style="font-weight:bold">'.$line.'</span>';
            }

            if (count($lines) !== 1) $lines[$i] = $lines[$i]."</br>";
        }
        return implode('', $lines);
    }
}
