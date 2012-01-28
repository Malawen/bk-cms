<?php
	/**
	 * Klasse, welche eine Verbinung zu einem MySQL-Server herstellt und die Querys verwaltet.
	 * 
	 * @author tobias
	 * @version 0.1
	 * @since 2.0b.4
	 *
	 */
	class bkMysql {
		private $connection;
		private $user;
		private $password;
		private $server;
		private $dbName;
		
		/**
		 * Legt ein neues Objekt der bkMysql-Klasse an.
		 * Dabei wird automatisch eine Verbindung zum MySQL-Server hergestellt und die angegebene Datenbank ausgewŠht.
		 * 
		 * @param String $user Benutzername
		 * @param String $password Passwort
		 * @param String $server Serveradresse
		 * @param String $dbName Datenbankname
		 */
	 	function __construct($user, $password, $server, $dbName) {
	 		$this->user = $user;
	 		$this->password = $password;
	 		$this->server = $server;
	 		$this->dbName = $dbName;
	 		
	 		$this->connect();
	 	}
	 	
	 	/**
	 	 * Trennt die Verbindung zum MySQL-Server.
	 	 * Gibt auch sonstigen Speicher wieder frei.
	 	 */
	 	function __destruct() {
	 		mysql_close($this->connection);
	 		$this->connection = NULL; unset($this->connection);
	 		$this->user = NULL; unset($this->user);
	 		$this->password = NULL; unset($this->password);
	 		$this->server = NULL; unset($this->server);
	 		$this->dbName = NULL; unset($this->dbName);
	 	}
	 	
	 	/**
	 	 * Stellt die Verbindung zum MySQL-Server und der Datanbank her und ŸberprŸft diese.
	 	 * Wenn ein Fehler wŠhrend dem Verbindungsaufbau vorliegt, wird dieser ausgegeben und das Script abgebrochen.
	 	 */
	 	private function connect() {
	 		$this->connection = mysql_connect($this->server, $this->user, $this->password);
	 		if(!$this->connection) {
	 			trigger_error("Unable to connect to MySQL-Server \"$this->server\" aus user \"$this->user\"!", E_ERROR);
	 		}	else {
	 			$dbSelected = mysql_select_db($this->dbName);
	 			if(!$dbSelected) {
	 				trigger_error("Can't use database \"$this->dbName\" at MySQL-Server \"$this->server\"!", E_ERROR);
	 			}
	 		}
	 	}
		
	 	/**
	 	 * FŸhrt einen SQL-Query auf dem MySQL-Server aus.
	 	 * 
	 	 * @param String $query SQL-Query
	 	 * @return FŸr SELECT, SHOW, DESCRIBE, EXPLAIN wird die Ergebinsmenge (Typ resource) zurŸckgegeben oder im Fehlerfall "false".
	 	 * FŸr INSERT, UPDATE, DELETE, DROP wird im Erfolgsfall "true" im Fehlerfall "false" zurŸckgegeben.
	 	 */
	 	public function query($query) {
	 		return mysql_query($query, $this->connection);
	 	}
	 	
	 	/**
	 	 * Konvertiert das Ergebnis eines MySQL-Querys in ein angegebenes Format.
	 	 * 		 ARRAY_A - Assoziatives Array (Feldnamen)
	 	 * 		 ARRAY_N - Nummerisches Array (Durchnummerriert)
	 	 * 		 ARRAY_B - Assoziatives und Nummerisches Array (Feldnamen und Durchnummerriert)
	 	 * 		OBJECT_A - Objekt
	 	 * 
	 	 * @param resource $result Ergebins eines MySQL-Querys
	 	 * @param CONVERT_TYPE $type Format, in welches konviertiert werden soll
	 	 * @param bool $comprimise gibt an, ob das Ergebnis wenn es nur eine "Zeile" gibt die Zeilen ignorieren soll
	 	 * @return Array|Objekt Konvertiertes Ergebnis einer MySQL-Abfrage
	 	 */
	 	public function convertQuery($result, $type, $comprimise = true) {
	 		if(is_bool($result)) {
	 			return $result;
	 		}
	 		
	 		switch($type) {        
      	case ARRAY_A:
          while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		        $return[] = $row;
          }
      	break;
        
      	case ARRAY_N:
          while($row = mysql_fetch_array($result, MYSQL_NUM)) {
		        $return[] = $row;
          }
     		break;
      
      	case ARRAY_B:
          while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
		        $return[] = $row;
          }
      	break;
      
      	case OBJECT_A:
          while($row = myysql_fetch_object($result)) {
		       	$return[] = $row;
          }
      	break;
    	}
    	
    	if($comprimise && count($return) == 1) {
    		return $return[0];
    	} else {
    		return $return;
    	}
	 	}
	 	
	 	/**
	 	 * FŸhrt einen SQL-Query auf dem MySQL-Server aus und konvertiert das Ergebnis danach gemŠ§ den Angaben von $type.
	 	 *		 ARRAY_A - Assoziatives Array (Feldnamen)
	 	 * 		 ARRAY_N - Nummerisches Array (Durchnummerriert)
	 	 * 		 ARRAY_B - Assoziatives und Nummerisches Array (Feldnamen und Durchnummerriert)
	 	 * 		OBJECT_A - Objekt
	 	 * 
	 	 * @param String $query SQL-Query
	 	 * @param CONVERT_TYPE $type Format, in welches konviertiert werden soll
	 	 * @return FŸr SELECT, SHOW, DESCRIBE, EXPLAIN wird ein konvertiertes Ergebnis der MySQL-Abfrage zurŸckgegeben oder im Fehlerfall "false".
	 	 * FŸr INSERT, UPDATE, DELETE, DROP wird im Erfolgsfall "true" im Fehlerfall "false" zurŸckgegeben.
	 	 */
	 	public function convertedQuery($query, $type) {
	 		$mysqlResult = $this->query($query);
	 		if(is_bool($mysqlResult)) {
	 			return $mysqlResult;
	 		} else {
	 			return $this->convertQuery($mysqlResult, $type);
	 		}
	 	}
	}
?>