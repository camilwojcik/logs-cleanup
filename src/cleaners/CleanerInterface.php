<?php

interface Cleaner
{
    public function clearAll(): void;

    public function clear(DateTime $date): void;
}