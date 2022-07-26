<?php

final class CleanerFactory{
    public static function factory(string $s): Cleaner
    {
        //depending on string contents return fileCleaner or DBCleaner;
        //?(DBCleaner should contain eighter DSN or provider interface (change param to mixed type string|ProviderInterface))?
        if (str_contains($s, ':')) {
            //throw exception cause DB is yet unsupported
            throw new InvalidArgumentException('DBFormat is not supported!');
        }

        if (!file_exists($s)) {
            throw new Exception('Couldn`t find given file in path:' . $s);
        }
        return new TextFileCleaner($s);

        /**
         *TODO://
         * if(filesize($s) > 512 * 1024){ // 512 KB
         *   return new TextFileCleaner($s);
         * }else{
         *   return new SmallTextFileCleaner($s);
         * }
         */
    }
}