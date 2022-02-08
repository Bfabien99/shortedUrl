<?php

    class db{

        private $table = 'link';

        public function dbConnect() 
        {
            $dsn="mysql:dbname=short;host=localhost";
            $password = "";
            $user = "root";

            $connect = new PDO($dsn,$user,$password,[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);

            if (!$connect) 
            {
                return new \Exception("Database cannot connect");
            }
            else
            {   
                return $connect;
            }
        }

        public function create($id,$url,$shorted)
        {
            $db = $this->dbConnect();
            $query = $db->prepare('UPDATE '.$this->table.' SET url = :url, shorted = :shorted WHERE id =:id');
            $result = $query->execute([
                "id" => $id,
                "url" => $url,
                "shorted" => $shorted,
            ]);

            return $result;
        }

        public function geturl()
        {
            $db = $this->dbConnect();
            $query = $db->prepare('SELECT url FROM '.$this->table);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function getshorted()
        {
            $db = $this->dbConnect();
            $query = $db->prepare('SELECT shorted FROM '.$this->table);
            $query->execute();
            $result = $query->fetch();
            return $result;
        }

    }