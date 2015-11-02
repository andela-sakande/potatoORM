<?php

namespace Sirolad\Interfaces;

/**
 * Interface for the main class
 * */
interface PotatoInterface
{
    public function __set($field, $value);

    public function tableName();

    public function getRecord();

    public function find($record);

    public function where($field, $value);

    public function getAll();

    public function save();

    public function destroy($record);
}
