<?php

class LogCleaner{

    private static ?LogCleaner $instance = null;

    private array $cleanerCollection;

    private function __construct(){}

    /**
     * Gets instance of cleaner.
     * Not sure if it should be singleton
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }

    public function addCleaner(Cleaner $cleaner):void
    {
        $this->cleanerCollection[] = $cleaner;
    }

    /**
     * Iterates throught Cleaners and deletes logs older than given time
     * @var DateTime $dateTime - DateTime to clear log entries
     */
    public function clear(DateTime $dateTime):int
    {
        if(empty($this->cleanerCollection)){
            throw new Exception('Cant clear logs without initialised cleaners!');
        }

        foreach($this->cleanerCollection as $cleaner){
            $cleaner->clear($dateTime);
        }

        return count($this->cleanerCollection);
    }

}