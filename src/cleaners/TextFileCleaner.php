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
        $match = null;
        $reading = fopen($this->path, 'r');
        $writing = fopen($this->path . '.tmp', 'w');

        $replaced = false;
        $latestDate = null;

        //TODO:// Cleaner for small files (without looping line by line if size of file is < few MB)
        while (!feof($reading)) {
            unset($match);
            $line = fgets($reading);
            //Regex gets dateTime from format YYY-MM-DD HH-MM-SS between [square braces]
            if(preg_match('/(?<=\[)\d{4}-[01]\d-[0-3]\d [0-2]\d:[0-5]\d:[0-5]\d(?=\])/', $line, $match) >= 1){
                $latestDate = new DateTime($match[0]);
            }
            if($latestDate < $dateTime){
                $replaced = true;
            }
            if($latestDate > $dateTime){
                fputs($writing, $line);
            }
        }

        fclose($reading);
        fclose($writing);

        // do not overwrite the file if we didn't remove anything
        if ($replaced){
            rename($this->path . '.tmp', $this->path);
        } else {
            unlink($this->path . '.tmp');
        }
    }

}