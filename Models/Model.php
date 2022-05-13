<?php
namespace Models;

use Exception;
use RedisModel;

abstract class Model implements Interfaces\Model
{
    protected array $fillable = [];
    protected string $table;

    /**
     * @throws Exception
     */
    public function save()
    {
        $this->getInstance($this)->save();
    }

    /**
     * @param Interfaces\Model $model
     * @throws Exception
     */
    public function delete()
    {
        $this->getInstance($this)->delete();
    }

    /**
     * @throws Exception
     */
    public function get()
    {
       return $this->getInstance($this)->get();
    }

    /**
     * @param Interfaces\Model $model
     * @return Interfaces\Model
     * @throws Exception
     */
    private function getInstance(Interfaces\Model $model): Interfaces\Model
    {
        switch (ENV['DB_CONNECTION']){
            case 'redis':
                return new RedisModel($model);
                break;
            default:
                throw new Exception('invalid db connection');//todo create custom exception
        }
    }
}