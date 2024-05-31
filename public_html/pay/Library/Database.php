<?php

  Namespace Library;

  Use PDO;

  Class Database {

    Public Static Function connection()
    {
      try
      {
        $connection =
        new PDO
        (
          "mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS,
          array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
      }
      catch(PDOException $e)
      {
        exit($e->getMessage());
      }
      return $connection;
    }

    Public Static Function single($query,$parameters = [])
		{
			$query = self::connection()->prepare($query);
			$query->execute($parameters);
			return $query->fetch(PDO::FETCH_OBJ);
		}

    Public Static Function fetch($query,$parameters = [])
		{
			$query = self::connection()->prepare($query);
			$query->execute($parameters);
			return $query->fetchAll(PDO::FETCH_OBJ);
		}

    Public Static Function rowCount($query,$parameters=[])
    {
      $query = self::connection()->prepare($query);
			$query->execute($parameters);
			$query->fetchAll(PDO::FETCH_OBJ);
			return $query->rowCount();
    }

    Public Static Function lastInsertID($table)
		{
			$query = self::connection()->query("SHOW TABLE STATUS LIKE '$table'")->fetch(PDO::FETCH_ASSOC)['Auto_increment'];
			return $query;
		}

    Public Static Function sumColumb($table,$columbname,$conditions=null)
		{
			$query = self::connection()->query("select sum($columbname) from $table $conditions", PDO::FETCH_OBJ);
			return $query->fetchColumn();
		}

    Public Static Function insert($table,$data)
		{
			$values = array();
			$columns = array();
			foreach ($data as $column => $value) {
				$values[] = $value;
				$columns[] = $column;
			}
			$columnsAndMarks = implode("=?,", $columns) . "=?";
			$query = self::connection()->prepare("INSERT INTO " . $table . " SET " . $columnsAndMarks);
			return $query->execute($values);
		}

    Public Static Function update($table,$data,$conditions=null)
		{
			$values = array();
			$columns = array();
			foreach ($data as $column => $value) {
				$values[] = $value;
				$columns[] = $column;
			}
			$columnsAndMarks = implode("=?,", $columns) . "=?";
			$query = self::connection()->prepare("UPDATE " . $table . " SET " . $columnsAndMarks ." WHERE " . $conditions);
			return $query->execute($values);
		}

    Public Static Function delete($table,$conditions=null,$parameters=[])
		{
			$query = self::connection()->prepare("DELETE FROM " . $table . " WHERE " . $conditions);
			return $query->execute($parameters);
		}

  }
