<?php

    class DatabaseTable {

        private $PDO;
        private $table;
        private $primaryKey;
        private $className;
        private $constructorArgs;

        public function __construct(\PDO $PDO, $table, $primaryKey, string $className = null, array $constructorArgs = []) {
            $this->PDO = $PDO;
            $this->table = $table;
            $this->primaryKey = $primaryKey;
            $this->className = $className ? $className : '\stdClass';
            $this->constructorArgs = $constructorArgs;
        }

        private function query($sql, $pars=[]) {

            $query = $this->PDO->prepare($sql);
            $query->execute($pars);
    
            return $query;
        }

        public function findAll() {
    
            $query = 'SELECT * FROM `' . $this->table . '`';

            $result = $this->query($query);

            return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
        }

        public function findById($id) {
    
            $id = $this->adjustId($id);

            $pars = [];
            $sql = 'SELECT * FROM `' . $this->table . '` 
                WHERE ';
 
            for ($i = 0; $i < count($this->primaryKey); $i++) {
                $pk = $this->primaryKey[$i];
                
                $sql .= '`' . $pk . '` = :primaryKey' . $i;
                $sql .= ' AND ';

                $pars['primaryKey' . $i] = $id[$pk];
            }

            $sql = rtrim($sql, ' AND ');

            $query = $this->query($sql, $pars);
    
            return $query->fetchObject($this->className, $this->constructorArgs);  
        }

        public function find($column, $value) {

            $pars = [':value' => $value];
            $sql = 'SELECT * FROM `' . $this->table . '` 
                WHERE `' . $column . '` = :value';

            $result = $this->query($sql, $pars);
    
            return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);

        }
        
    }
