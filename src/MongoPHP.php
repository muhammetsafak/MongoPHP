<?php
/**
 * MongoPHP.php
 *
 * This file is part of MongoPHP.
 *
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2022 Muhammet ŞAFAK
 * @license    https://github.com/muhammetsafak/MongoPHP/blob/main/LICENSE  MIT
 * @version    1.0
 * @link       https://www.muhammetsafak.com.tr
 */

declare(strict_types=1);

namespace MuhammetSafak\MongoPHP;

use \MongoDB\Driver\{Manager, BulkWrite, Query};

use function extension_loaded;
use function strpos;

class MongoPHP
{
    /**
     * mongodb://[username:password@]host1[:port1][,host2[:port2],...[,hostN[:portN]]][/[database][?options]]
     *
     * @var string
     */
    protected string $dsn;

    protected bool $isConnect = false;

    protected Manager $manager;
    protected BulkWrite $bulkWrite;
    protected string $database;

    protected ?int $rowCount = null;
    protected array $errors = [];

    public function __construct(string $dsn, string $database)
    {
        $this->dsn = $dsn;
        if(!extension_loaded('MongoDB')){
            throw new \RuntimeException('MongoPHP needs the MongoDB PHP extension to work.');
        }
        $this->connection();
        $this->database = $database;
    }

    public function connection()
    {
        if($this->isConnect !== FALSE){
            return;
        }
        try{
            $this->manager = new Manager($this->dsn);
            $this->isConnect = true;
        }catch (\Exception $e) {
            throw new \RuntimeException('MongoPHP connection failed. ' . $e->getMessage());
        }
    }

    public function rowCount(): int
    {
        return $this->rowCount ?? 0;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function insert(array $data): self
    {
        $this->getBulkWrite()->insert($data);
        return $this;
    }

    public function read(string $collection, array $filter, ?array $options = []): array
    {
        $query = new Query($filter, $options);
        if(strpos($collection, '.') === FALSE){
            $collection = $this->database . '.' . $collection;
        }
        return ($this->manager->executeQuery($collection, $query))->toArray();
    }

    public function update(array $query, array $values, ?array $options = []): self
    {
        $this->getBulkWrite()->update($query, $values, $options);
        return $this;
    }

    public function delete(array $query, ?array $options = []): self
    {
        $this->getBulkWrite()->delete($query, $options);
        return $this;
    }

    public function save(string $collection): bool
    {
        if(!isset($this->bulkWrite)){
            $this->errors[] = 'No changes were found to save.';
            return false;
        }
        if(strpos($collection, '.') === FALSE){
            $collection = $this->database . '.' . $collection;
        }
        $result = $this->manager->executeBulkWrite($collection, $this->bulkWrite);
        $this->rowCount = $this->bulkWrite->count();
        unset($this->bulkWrite);
        if($result->isAcknowledged() === FALSE){
            foreach ($result->getWriteErrors() as $err) {
                $this->errors[] = '#' . $err->getCode() . ' : ' . $err->getMessage();
            }
            return false;
        }
        return true;
    }

    protected function getBulkWrite(): BulkWrite
    {
        if(!isset($this->bulkWrite)){
            $this->bulkWrite = new BulkWrite();
        }
        return $this->bulkWrite;
    }

}
