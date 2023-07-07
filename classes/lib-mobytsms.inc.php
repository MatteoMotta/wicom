<?php
/**
 * Libreria per l'invio di SMS e la gestione delle operazioni di BackOffice tramite richiesta POST HTTP
 *
 *
 * @version 1.4.4
 * @package Mobyt-ModuleHTTP
 * @author  Mobyt srl
 * @copyright (C) 2003-2005 Mobyt srl
 * @license https://www.mobyt.it/bsd-license.html BSD License
 *
 */


/*
 * v. 1.4.4 aggiunta la possibilita di assegnare un codice alla spedizione [setBatchCode()]
 */

/**#@+
 * @access	private
 */
/**
 * Versione della classe
 */
define('MOBYT_PHPSMS_VERSION',	'1.4.4');

/**
 * Tipo di autenticazione basata su IP, con password inviata in chiaro
 */
define('MOBYT_AUTH_PLAIN',	2);

/**
 * Qualità messaggi bassa (LQS)
 */
define('MOBYT_QUALITY_LQS',	1);
/**
 * Qualità messaggi media (MQS)
 */
define('MOBYT_QUALITY_MQS',	2);
/**
 * Qualità messaggi alta (HQS)
 */
define('MOBYT_QUALITY_HQS',	3);
/**
 * Qualità messaggi automatica
 */
define('MOBYT_QUALITY_AUTO',	4);
/**
 * Qualità messaggi automatica con notifica
 */
define('MOBYT_QUALITY_AUTO_NY',	5);



/**
 * @global array Array di conversione per le qualità
 */
$GLOBALS['mobyt_qty'] = array(
		MOBYT_QUALITY_LQS		=> 'll',
		MOBYT_QUALITY_MQS		=> 'l',
		MOBYT_QUALITY_HQS		=> 'h',
		MOBYT_QUALITY_AUTO		=> 'a',
		MOBYT_QUALITY_AUTO_NY	=> 'n'
	);
	
/**#@-*/


/**
 * Classe per l'invio di SMS e il controllo del credito residuo tramite richiesta POST/GET HTTP
 *
 * Le impostazioni utilizzate di default sono:
 * - Mittente: <b>"MobytSms"</b>
 * - Autenticazione: <b>basata su IP con password inviata in chiaro</b>
 * - Qualità: <b>Non impostata</b> - Il default è l'utilizzo della modalità automatica
 *
 * @package Mobyt-ModuleHTTP
 * @example SendSingleSms.php Invio di un singolo sms 
 */
class mobytSms
{
	/**#@+
	 * @access	private
	 * @var		string
	 */
	var $auth = MOBYT_AUTH_PLAIN;
	var $quality;
	var $from;
	var $domain = 'http://client.mobyt.it';
	var $login;
	var $pwd;
	var $udh;
	var $batchCode;
	/**#@-*/
	
	/**
	 * @param string	Username di accesso (Login)
	 * @param string	Password di accesso
	 * @param string	Intestazione mittente
	 *
	 * @see setFrom
	 */
	function mobytSms($login, $pwd, $from = 'MobytSms')
	{
		$this->login = $login;
		$this->pwd = $pwd;
		$this->setFrom($from);
	}
	
	/**
	 * Imposta intestazione mittente
	 *
	 * Il mittente può essere composto da un massimo di 11 caratteri alfanumerici o un numero telefonico con prefisso internazionale. 
	 *
	 * @param string	Intestazione mittente
	 */
	function setFrom($from)
	{
		$this->from = substr($from, 0, 14);
	}
	
	/**
	 * Imposta l'indirizzo URL del dominio dell'amministratore/rivenditore sul quale dovranno loggarsi gli eventuali clienti
	 * L'URL deve essere nel formato 'http://www.miodominio.it'
	 *
	 * @param string    URL
	 */
	function setDomain($domain)
	{
		$this->domain = $domain;
	}
	
	
	/**
	 * Utilizza l'autenticazione con password in chiaro basata sull'IP
	 */
	function setAuthPlain()
	{
		$this->auth = MOBYT_AUTH_PLAIN;
	}
	
	
	/**
	 * Imposta la qualità messaggi come bassa
	 */
	function setQualityLow()
	{
		$this->quality = MOBYT_QUALITY_LQS;
	}
	
	/**
	 * Imposta la qualità messaggi come media
	 */
	function setQualityMedium()
	{
		$this->quality = MOBYT_QUALITY_MQS;
	}
	
	/**
	 * Imposta la qualità messaggi come alta
	 */
	function setQualityHigh()
	{
		$this->quality = MOBYT_QUALITY_HQS;
	}
	
	/**
	 * Imposta la qualità messaggi automatica
	 */
	function setQualityAuto()
	{
		$this->quality = MOBYT_QUALITY_AUTO;
	}
	
	/**
	 * Imposta la qualità messaggi automatica con notifica
	 */
	function setQualityAutoNotify()
	{
		$this->quality = MOBYT_QUALITY_AUTO_NY;
	}
		
	
	/**
	 * Controlla il credito disponibile intermini di credito in euro o sms disponibili.
	 *
	 * @returns string In caso di successo 'OK <valore>', dove <valore> è il numero di sms o il credito in euro a seconda del 
	 * parametro type specificato.<br> In caso di errore 'KO <testo_errore>
	 *
	 * @example ControllaSMS.php Controllo il credito residuo e i messaggi disponibili
	 */
	function getCredit($type='credit')
	{
		
		$fields = array(
				'user'		=> $this->login,
				'pass'	=> $this->pwd,
			);
		
		$fields['type'] = $type ;
		$fields['domain'] = $this->domain;
		$fields['path'] = '/sms/credit.php';
		
		return trim($this->httpPost($fields));
	}

	/**
	 * Imposta il codice della spedizione
	 */
	function setBatchCode($batchCode)
	{
		$this->batchCode = $batchCode;
	}
		

	/**
	 * Invia un SMS
	 *
	 * Nel caso sia utilizzata la qualità automatica con notifica, serà necessario passare un identificatore univoco di max 20     * caratteri numerici come terzo parametro. Qualora non venisse impostato, ne verrà generato uno casuale in maniera    
	 * automatica, per permettere il corretto invio del messaggio.
	 *
	 * @param string Numero telefonico con prefisso internazionale (es. +393201234567)
	 * @param string Testo del messaggio (max 160 caratteri)
	 * @param string Identificatore univoco del messaggio da utilizzare nel caso sia richiesta la notifica
	 * @param string Tipologia di messaggio (TEXT, WAPPUSH)
	 * @param string Indirizzo URL cui dovrà collegarsi il destinatario in caso di SMS WAPPUSH
	 * @param integer Se uguale a 1 verrà restituito l'identificativo univo della spedizione da utilizzare per il controllo dello 
	 * stato della spedizione tramite POST HTTP
	 *
	 * @returns string Risposta ricevuta dal gateway ("OK ..." o "KO ..."). In caso di successo verrà visualizzato anche il costo del messaggio inviato
	 *
	 * @example SendSingleSms.php Invio di un singolo sms 
	 */
	function sendSms($rcpt, $text, $act='', $operation='TEXT', $url='',$return_id='')
	{
		global $mobyt_qty, $mobyt_ops;
		
		$fields = array(
				'sender'		=> $this->from,
				'rcpt'		=> $rcpt,
				'data'		=> $text,
				'user'		=> $this->login,
				'operation' => $operation,
				'url'       => $url,
				'return_id'=> $return_id,
				'batch_code'=> $this->batchCode
			);

		if (isset($mobyt_qty[$this->quality]))
			$fields['qty'] = $mobyt_qty[$this->quality];
		
		
		$fields['pass'] = $this->pwd;
		
		$fields['domain'] = $this->domain;
		
		$fields['path'] = '/sms/send.php';
		
		return trim($this->httpPost($fields));
	}
	
	/**
	 * Invia un SMS a più destinatari
	 *
	 * Nel caso sia utilizzata la qualità automatica con notifica, serà necessario passare un array associativo come primo 
	 * parametro, le cui chiavi siano identificatori univoci di max 20 caratteri numerici.
	 *
	 * @example SendMultiSms.php Invio di un sms a più numeri con autenticazione tramite password in chiaro
	 *
	 * @param array Array di numeri telefonici con prefisso internazionale (es. +393201234567)
	 * @param string Testo del messaggio (max 160 caratteri)
	 * @param string Tipologia di messaggio (TEXT, WAPPUSH)
	 * @param string Indirizzo URL cui dovrà collegarsi il destinatario in caso di SMS WAPPUSH
	 * @param integer Se uguale a 1 verrà restituito l'identificativo univo della spedizione da utilizzare per il controllo dello 
	 * stato della spedizione tramite POST HTTP
	 *
	 * @returns string Elenco di risposte ricevute dal gateway ("OK ..." o "KO ..."), separate da caratteri di "a capo" (\n)
	 */
	function sendMultiSms($rcpts, $data, $operation='TEXT', $url='',$return_id='')
	{
        global $mobyt_qty, $mobyt_ops;
		
		if (!is_array($rcpts))
			return $this->sendSms($rcpts, $data);
		

		$fields = array(
				'user'		=> $this->login,
				'pass'	=> $this->pwd,
				'sender'		=> $this->from,
				'data'		=> $data,
				'rcpt'      => join(',',$rcpts),
				'operation' => $operation,
				'url'       => $url,
				'return_id'=> $return_id,
				'batch_code'=> $this->batchCode
			);
		
		
		if (isset($mobyt_qty[$this->quality]))
			$fields['qty'] = $mobyt_qty[$this->quality];
		
		$fields['domain'] = $this->domain;
		$fields['path']='/sms/batch.php';
		
		return trim($this->httpPost($fields));
	}

	/**
	 * Invia richiesta MNC
	 *
	 * @param array Array di numeri telefonici con prefisso internazionale (es. +393201234567)
	 * @param string Testo del messaggio (max 160 caratteri)
	 * @param integer Se uguale a 1 verrà restituito l'identificativo univo della spedizione da utilizzare per il controllo dello 
	 * stato della spedizione tramite POST HTTP
	 *
	 * @returns string Risposta ricevuta dal gateway ("OK ..." o "KO ..."). 
	 *
	 * @example SendMNC.php Invio di una richiesta MNC 
	 */
	function sendMNC($numbers,$return_id='')
	{
		global $mobyt_qty, $mobyt_ops;
		
		$fields = array(
				'user'		=> $this->login,
				'pass'	=> $this->pwd,
				'numbers'       => $numbers,
				'return_id'=> $return_id
			);
		
		$fields['domain'] = $this->domain;
		
		$fields['path'] = '/sms/mnc.php';
		
		return trim($this->httpPost($fields));
	}
	
	/**
	 * Controllo satto delle spedizioni
	 *
	 * @param string Identificativo univoco della spedizione
	 * @param string Tipo di report (queue, notify, mnc)
	 * @param string Schema del report
	 *
	 * @returns string Risposta ricevuta dal gateway ("OK ..." o "KO ..."). 
	 *
	 * @example ControlloStato.php Verifica stato della spedizione 
	 */
	function sendStatus($id, $type, $schema='1')
	{
		global $mobyt_qty, $mobyt_ops;
		
		$fields = array(
				'user'		=> $this->login,
				'pass'	    => $this->pwd,
				'id'        => $id,
				'type'      => $type,
				'schema'    => $schema
			);
	
		
		$fields['domain'] = $this->domain;
		
		$fields['path'] = '/sms/batch-status.php';
		
		return trim($this->httpPost($fields));
	}

	/**
	 * Send an HTTP POST request, choosing either cURL or fsockopen
	 *
	 * @access private
	 */
	
	function httpPost($fields)
	{
		$qs = array();
		foreach ($fields as $k => $v)
			$qs[] = $k.'='.urlencode($v);
		$qs = join('&', $qs);
		
		
		if (function_exists('curl_init'))
			return mobytSms::httpPostCurl($qs, $fields['domain'].$fields['path']);
	
		
		$errno = $errstr = '';
		if ($fp = @fsockopen(substr($fields['domain'],7), 80, $errno, $errstr, 30)) 
		{   
			fputs($fp, "POST ".$fields['path']." HTTP/1.0\r\n");
			fputs($fp, "Host: ".substr($fields['domain'],7)."\r\n");
			fputs($fp, "User-Agent: phpMobytSms/".MOBYT_PHPSMS_VERSION."\r\n");
			fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-Length: ".strlen($qs)."\r\n");
			fputs($fp, "Connection: close\r\n");
			fputs($fp, "\r\n".$qs);
			
			$content = '';
			while (!feof($fp))
				$content .= fgets($fp, 1024);
			
			fclose($fp);
			
			return preg_replace("/^.*?\r\n\r\n/s", '', $content);
		}
		
		return false;
	}

	/**
	 * Send an HTTP POST request, through cURL
	 *
	 * @access private
	 */
	function httpPostCurl($qs, $domain)
	{   
		if ($ch = @curl_init($domain))
		{   
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'phpMobytSms/'.MOBYT_PHPSMS_VERSION.' (curl)');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $qs);
		
			return curl_exec($ch);
		}
		
		return false;
	}
	
	
}



/**
 * Classe per la gestione delle attività di BackOffice
 *
 * Le impostazioni utilizzate di default sono:
 * - Autenticazione: <b>Indirizzo IP + Password in chiaro</b>
 *
 * @package Mobyt-ModuleHTTP
 * @example ControlloOperazioni.php  
 *
 */
class BackOffice
{
	/**#@+
	 * @access	private
	 * @var		string
	 */
	var $auth = MOBYT_AUTH_PLAIN;
	var $smsusername;
	var $smspassword;
	var $domain = 'http://client.mobyt.it';
	/**#@-*/
	
	/**
	 * @param string	Username di accesso (Login)
	 * @param string	Password di accesso
	 *
	 */
	function BackOffice($login, $pwd)
	{
		$this->smsusername = $login;
		$this->smspassword = $pwd;
	}
	
	/**
	 * Imposta l'indirizzo URL del dominio dell'amministratore/rivenditore sul quale dovranno loggarsi gli eventuali clienti
	 * L'URL deve essere nel formato 'http://www.miodominio.it'
	 *
	 * @param string    URL
	 */
	function setDomain($domain)
	{
		$this->domain = $domain;
	}
	
	
	/** Creazione di un nuovo cliente
	 *
	 * @param string Nome del cliente che si desidera creare
	 * @param string Username che il cliente utilizzerà per autenticarsi
	 * @param string Password che il cliente utilizzerà per autenticarsi 
	 * @param array Altre informazioni opzionali (email, dominio, identificativo tariffa..)
	 *
	 * @returns string In caso di successo 'OK <id del nuovo cliente creato>'. in caso di insuccesso 'KO <messaggio di errore>
	 *
	 * @example CreaCliente.php
	 */
	function AggiungiCliente($name, $username, $password, $options)
	{
		
		$fields = array(
		        'smsusername' => $this->smsusername,
				'smspassword' => $this->smspassword,
				'name'		=> $name,
				'username'		=> $username,
				'password'		=> $password
			);
			
		$fields['email'] = isset($options['email']) ? $options['email'] : '';
		$fields['tpl_id'] = isset($options['tpl_id']) ? $options['tpl_id'] : '';
		$fields['contact'] = isset($options['contact']) ? $options['contact'] : '';
		$fields['ref_id'] = isset($options['ref_id']) ? $options['ref_id'] : '';
		$fields['reseller'] = isset($options['reseller']) ? $options['reseller'] : '';
		$fields['vhost'] = isset($options['vhost']) ? $options['vhost'] : '';
		
		$fields['domain'] = $this->domain;
		$fields['path'] = '/backoffice/client-add.php';
		
		return trim($this->httpPost($fields));
	}
	
	/** Assegnazione crediti al cliente specificato
	  * @param string Identificativo del cliente cui assegnare il credito
	  * @param string Identificativo univoco della tariffa
	  * @param array Altre informazioni opzionali (credit)
	  *
	  * @returns string In caso di successo 'OK <id del nuovo credito>'.<br> In caso di insuccesso 'KO <messaggio di errore>
	  *
	  * @example AssegnaCrediti.php
	 */
	function AssegnaCrediti($u_id,$bill_id,$options){
		
		$fields = array(
		        'smsusername' => $this->smsusername,
				'smspassword' => $this->smspassword,
				'u_id'        => $u_id,
				'bill_id'     => $bill_id
				);
		
		$fields['credit'] = isset($options['credit']) ? $options['credit'] : '';
		
		$fields['domain'] = $this->domain;
		$fields['path'] = '/backoffice/credit-add.php';
		
		return trim($this->httpPost($fields));
	}
	
	/** Controllo del credito residuo di un cliente
	  * @param string Identificativo univoco del cliente di cui si desidera conoscere il credito residuo
	  *
	  * @returns string In caso di successo 'OK <credito in euro>'. in caso di insuccesso 'KO <messaggio di errore>
	  *
	  * @example ControlloCrediti.php
	  */
	function ControlloCredito($u_id){
		
			$fields = array(
		        'smsusername' => $this->smsusername,
				'smspassword' => $this->smspassword,
				'u_id'        => $u_id
				);
				
			$fields['domain'] = $this->domain;
			$fields['path'] = '/backoffice/credit-get.php';
			
			return trim($this->httpPost($fields));
	}
	
	/** Controlla delle operazioni di BackOffice eseguite
	  * @param string Tipologia di operazione eseguita ('credits' al momento è l'unica supportata)
	  * @param array Altre informazioni opzionali (identificativo cliente, data inizio report, data fine report)
	  *
	  * @returns array In caso di successo ritornerà un report in cui la prima riga contiene l'intestazione dei campi e le 
	  * successive i dati. I campi sono separati da tabulazione e le righe termiante dai caratteri '<CR><LF>'.In caso di 
	  * insuccesso 'KO <messaggio di errore>
	  *
	  * @example ControlloOperazioni.php
	  */
	function ControlloOperazioni($type, $options){
	
			$fields = array(
		        'smsusername' => $this->smsusername,
				'smspassword' => $this->smspassword,
				'type'        => $type
				);
				
			$fields['u_id'] = isset($options['u_id']) ? $options['u_id'] : '';
			$fields['from'] = isset($options['from']) ? $options['from'] : '';
			$fields['to'] = isset($options['to']) ? $options['to'] : '';
			
			$fields['domain'] = $this->domain;
			$fields['path'] = '/backoffice/userlog-get.php';
			
			return trim($this->httpPost($fields));
	}
	
	/** Creazione/assegnazione del servizio di ricezione
	  *
	  * @param string Identificativo del cliente cui associare il servizio 
	  * @param string Numero di telefono ricezione
	  * @param string Numero di codici da creare
	  *
	  * @returns string In caso di successo 'OK <codici creati>'.<br> In caso di insuccesso 'KO <messaggio di errore>
	  *
	  *  @example Ricezione.php
	  */
	function Ricezione($u_id,$dest,$options){
			
			$fields = array(
		        'smsusername' => $this->smsusername,
				'smspassword' => $this->smspassword,
				'u_id'        => $u_id,
				'dest'        => $dest
				);
		
			$fields['num'] = isset($options['num']) ? $options['num'] : '';
			
			$fields['domain'] = $this->domain;
			$fields['path'] = '/backoffice/recv-add.php';
			
			return trim($this->httpPost($fields));
	}
	
	
	/** Revoca del servizio di ricezione
	  *
	  * @param string Identificativo del cliente cui revocare il servizio 
	  * @param string Numero di telefono ricezione
	  * @param string Codice di condivisione da revocare al cliente
	  *
	  * @returns string In caso di successo 'OK'.<br> In caso di insuccesso 'KO <messaggio di errore>
	  *
	  *  @example RicezioneDel.php
	  */
	  
	function RevocaRicezione($u_id,$dest,$sharecode){
			
			$fields = array(
		        'smsusername' => $this->smsusername,
				'smspassword' => $this->smspassword,
				'u_id'        => $u_id,
				'dest'        => $dest,
				'sharecode'   => $sharecode
				);
		
			
			
			$fields['domain'] = $this->domain;
			$fields['path'] = '/backoffice/recv-del.php';
			
			return trim($this->httpPost($fields));
	}
	
	/** Attivazione/Disattivazione di un cliente
	  *
	  * @param string Identificativo del cliente da attivare/disattivare
	  * @param integer 0 = disattiva / 1 = attiva
	  *
	  * @returns string In caso di successo 'OK <stato cliente>'.<br> In caso di insuccesso 'KO <messaggio di errore>
	  *
	  *  @example ClientManagement.php
	  */
	function GestioneClienti($u_id, $active){
	
			$fields = array(
		        'smsusername' => $this->smsusername,
				'smspassword' => $this->smspassword,
				'u_id'        => $u_id,
				'active'        => $active
				);
	
			$fields['domain'] = $this->domain;
			$fields['path'] = '/backoffice/client-status.php';
			
			return trim($this->httpPost($fields));
	}
	
	/**
	 * Send an HTTP POST request, choosing either cURL or fsockopen
	 * 
	 * @access private
	 */
	function httpPost($fields)
	{
		$qs = array();
		foreach ($fields as $k => $v)
			$qs[] = $k.'='.urlencode($v);
		$qs = join('&', $qs);
		
		
		if (function_exists('curl_init'))
			return BackOffice::httpPostCurl($qs, $fields['domain'].$fields['path']);
		
		$errno = $errstr = '';
		if ($fp = @fsockopen("'".substr($fields['domain'], 6)."'", 80, $errno, $errstr, 30)) 
		{   
			fputs($fp, "POST ".$fields['path']." HTTP/1.0\r\n");
			fputs($fp, "Host: ".substr($fields['domain'], 6)."\r\n");
			fputs($fp, "User-Agent: phpMobytSms/".MOBYT_PHPSMS_VERSION."\r\n");
			fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-Length: ".strlen($qs)."\r\n");
			fputs($fp, "Connection: close\r\n");
			fputs($fp, "\r\n".$qs);
			
			$content = '';
			while (!feof($fp))
				$content .= fgets($fp, 1024);
			
			fclose($fp);
			
			return preg_replace("/^.*?\r\n\r\n/s", '', $content);
		}
		
		return false;
	}

	/**
	 * Send an HTTP POST request, through cURL
	 *
	 * @access private
	 */
	function httpPostCurl($qs, $domain)
	{    
		if ($ch = @curl_init($domain))
		{   
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'phpMobytSms/'.MOBYT_PHPSMS_VERSION.' (curl)');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $qs);
		
			return curl_exec($ch);
		}
		
		return false;
	}

}


/**
 * Classe per il controllo dei messaggi ricevuti tramite Web service SOAP
 *
 * Le impostazioni utilizzate di default sono:
 * - Autenticazione: <b>Basata su indirizzo IP e password in chiaro</b>
 *
 * @package Mobyt-ModuleHTTP
 * @example ControlloSMS-SOAP.php Controllo dei messaggi ricevuti
 * 
 */
class mobytSOAP
{
	/**
	 * @param string	Eventuale messaggio di errore
	 */
	var $errorMessage = '';

	/**#@+
	 * @access	private
	 * @var		string
	 */
	var $login;
	var $pwd;
	var	$auth = MOBYT_AUTH_PLAIN;
	var $domain = 'http://client.mobyt.it';
	/**#@-*/


	/**
	 * @param string	Username di accesso (Login)
	 * @param string	Password di accesso
	 */
	function mobytSOAP($login, $pwd)
	{
		$this->login = $login;
		$this->pwd = $pwd;
	}	
	
	
	/**
	 * Utilizza l'autenticazione con password in chiaro basata sull'IP
	 */
	function setAuthPlain()
	{
		$this->auth = MOBYT_AUTH_PLAIN;
	}

	/**
	 * Imposta l'indirizzo URL del dominio dell'amministratore/rivenditore sul quale dovranno loggarsi gli eventuali clienti
	 * L'URL deve essere nel formato 'http://www.miodominio.it'
	 *
	 * @param string    URL
	 */
	function setDomain($domain)
	{
		$this->domain = $domain;
	}
	

	/**
	 * 
	 *
	 * @param string	Nomero di ricezione
	 * @param string	Codice di condivisione
	 * @param string    Numero di messaggi da mostrare
	 *
	 *
	 * @returns mixed array di strutture recvSms (int Id messaggio, string Numero del mittente, string Testo del messaggio, 
	 * dateTime Data e ora di ricezione)
	 * 
	 * @example ControlloSMS-SOAP.php Controllo dei messaggi ricevuti
	 */
	function ControlloSmsSoap($rcpt, $sharecode, $messages)
	{
		
		if (is_array($rcpt))
				$rcpt = join(',', $rcpt);

		$client = new SoapClient($this->domain.'/wsdl/wsdl.php', array('trace'=>true, 'exceptions'=>true));

		$res = $client->receiveSms($this->login,$this->pwd,$rcpt,$sharecode,$messages);

		return $res;
	}
}

?>
