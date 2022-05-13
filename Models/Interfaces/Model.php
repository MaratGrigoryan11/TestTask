<?php
namespace Models\Interfaces;
interface Model
{
    public function save();

    /**
     * @return mixed
     */
    public function delete();
    public function get();
}