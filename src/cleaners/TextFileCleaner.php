<?php

class TextFileCleaner implements Cleaner{

    public function __construct(private String $path){
        if(!file_exists($this->path)){
            throw new Exception('Couldn`t find specified file!');
        }
    }
    
    public function clearAll(): void
    {
        file_put_contents($this->path, '');
    }

    public function clear(DateTime $dateTime): void
    {
        # code...
    }

}