<?php

/**
 * Legt f�r einen einzelnen Eintrag in einer Global einen Eintrag an und verkn�pft auszuf�hrende Funktionen mit dem Eintrag.
 *
 * @author Tobias Hecker <tobias@hecker-bk.de>
 * @version 0.1
 * @since 2.0b.4
 *
 */
class GlobalsFunction {
	/**
	 * Speichert die verschiedenen Funktionen im Format $f[$Funktions Name] = $Trigger Wert.<br />
	 * Wenn der $Trigger Wert == NULL ist, existiert kein Trigger.
	 */
	private $f;


	/**
	 * Erstellt ein neues Objekt der GlobalsFunction-Klasse und legt den ersten Eintrag an.
	 *
	 * @param String $func
	 * @param String $call
	 */
	function __construct($func, $call) {
		$this->f[$func] = $call;
	}


	/**
	 * Gibt den Trigger-Wert einer auf dem Objekt registrierten Funktion zur�ck.<br />
	 * Wenn die Funktion nicht existiert wird eine Warnung ausgegeben.
	 *
	 * @param String $name
	 */
	public function __get($name) {
		if(isset($this->f[$name])) {
			return $this->f[$name];
		}
		else {
			#TODO: Waring: Function does not existe in $objektName
		}
	}


	/**
	 * Sezt den Trigger-Wert in einer Funktion oder registriert eine neue Funktion.
	 *
	 * @param String $name
	 * @param Mixed $value
	 */
	public function __set($name, $value) {
		$this->f[$name] = $value;
	}


	/**
	 * L�st die Verkn�pfung mit einer Funktion auf.
	 *
	 * @param String $name
	 */
	public function __unset($name) {
		$this->f[$name] = NULL;
		unset($this->f[$name]);
	}


	/**
	 * Ruft alle verkn�pften Funktionen auf, unabh�nig davon ob ihr Trigger-Wert existiert oder nicht.<br />
	 * Jede Funktion wird mit den/dem �bergebenen Parametern aufgerufen.
	 *
	 * @param Mixed $arg
	 * @return die R�ckgabe werte der Funktionen in einem assoziativen Array
	 */
	public function call($arg) {
		$return = array();

		foreach($this->f as $func => $call) {
			if(is_array($arg)) {
				$return[$func] = array((String)$call => call_user_func_array($func, $arg));
			}
			else {
				$return[$func] = array((String)$call => call_user_func($func, $arg));
			}
		}

		return $return;
	}


	/**
	 * Ruft alle verkn�pften Funktionen auf, wenn ihr Tigger-Wert existiert oder sie keinen Tigger besitzt.<br />
	 * Jede Funktion wird mit den/dem �bergebenen Parametern aufgerufen.
	 *
	 * @param Mixed $arg
	 * @return die R�ckgabewerte der Funktionen in einem assoziativen Array
	 */
	public function callWithTrigger($arg) {
		$return = array();

		foreach($this->f as $func => $call) {
			if((String)$arg == (String)$call || $call == NULL) {
				if(is_array($arg)) {
					$return[$func] = array((String)$call => call_user_func_array($func, $arg));
				}
				else {
					$return[$func] = array((String)$call => call_user_func($func, $arg));
				}
			}
		}

		return $return;
	}


	/**
	 * Ruft alle verkn�pften Funktionen auf, nur wenn ihr Tigger-Wert existiert.<br />
	 * Jede Funktion wird mit den/dem �bergebenen Parametern aufgerufen.
	 *
	 * @param Mixed $arg
	 * @return die R�ckgabewerte der Funktionen in einem assoziativen Array
	 */
	public function callWithTriggerOnly($arg) {
		$return = array();

		foreach($this->f as $func => $call) {
			if((String)$arg == (String)$call) {
				if(is_array($arg)) {
					$return[$func] = array((String)$call => call_user_func_array($func, $arg));
				}
				else {
					$return[$func] = array((String)$call => call_user_func($func, $arg));
				}
			}
		}

		return $return;
	}


	/**
	 * Gibt alle registrierten Funktionen zur�ck.
	 */
	public function getAllFunctions() {
		return array_keys($this->f);
	}
}


/**
 * Verwaltet Funktionsaufrufe welche durch Globals ausgel�st werden.
 *
 * @author Tobias Hecker <tobias@hecker-bk.de>
 * @version 0.1
 * @since 2.0b.4
 */
class Globals {
	/**
	 * Art der Global auf welcher Funktionen registriert werden sollen.<br />
	 * Beispiele: "GET", "POST", "SERVER" ...
	 */
	private $typ;

	/**
	 * Array zum Speichern der Registrierungen.
	 */
	private $glob;


	/**
	 * Erzeugt eine neues Objekt vom Typ Globals.<br />
	 * �ber den $typ kann festgelegt werden, welche Global abgerufen werden soll.
	 *
	 * @param String $typ
	 */
	public function __constuct($typ) {
		//TODO: $typ existiert nicht... entweder Dummyfunktionen laden, oder Fehler ausgeben und Instanz l�schen
		$this->typ = (String)$typ;
		$this->glob = array();
	}

	/**
	 * Registriert einen neue Funktion auf der Global.<br />
	 * Dazu kann zus�tzlich ein Trigger �bergeben werden, um die Funktion nur auszuf�hren, wenn die Variable einen bestimmten Wert hat.
	 *
	 * @param String $name Name der Variable, welche die Funktion ausl�sen soll.
	 * @param String $func Name der Funktion
	 * @param Mixed $value Wert, bei welchem die Funktion ausgel�st werden soll
	 */
	public function registerFunction($name, $func, $value = NULL) {
		if(!isset($this->glob[$name])) {
			$this->glob[$name] = new GlobalsFunction($func, $value);
		}
		else {
			$this->glob[$name]->$func = $value;
		}
	}

	/**
	 * Entfernt die Registration einer Funktion auf der Global.
	 *
	 * @param String $name Name der Variable, die Funktion ausl�sen soll
	 * @param String $func Name der Funktion
	 */
	public function unregisterFunction($name, $func) {
		if(isset($this->glob[$name])) {
			$this->glob[$name]->$func = NULL;
		}
	}

	/**
	 * Wird �ber ->$name($arg) aufgerufen.<br />
	 * F�hrt die auf der Varibalen hinterlegte Funktionen mit den gegebenen �bergabeparametern aus, wenn diese exsistiert.
	 *
	 * @param String $name Name der Variable, welche die Funktion ausl�sen soll
	 * @param Mixed $arg �bergabeparameter
	 */
	public function __call($name, $arg) {
		if(isset($this->glob[$name])) {
			$this->glob[$name]->call($arg);
		}
	}

	/**
	 * Pr�ft ob auf den verschiedenen Variablen der Global eine Funktion registriert wurde. <br />
	 * Ist eine Funktion registriert, wird diese mit dem Wert der Variable aus Parameter aufgerufen.
	 */
	public function call() {
		foreach($GLOBALS[$this->typ] as $g => $v) {
			if(isset($this->glob[$g])) {
				$this->glob[$g]->callWithTrigger($v);
			}
		}
	}
}
?>