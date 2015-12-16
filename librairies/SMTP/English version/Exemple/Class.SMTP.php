<?php
/********************************************************************************
*
* Source Name :
*       Class SMTP
* Default file name :
*       Class.SMTP.php
* Author :
*       Nuel Guillaume alias Immortal-PC
* Web site :
*       http://immortal-pc.info/
*
* Translate by :
*		Pierre CORBEL
* Web site :
*		http://www.some-ideas.net/
*
********************************************************************************/

class SMTP {
    // Domain of the server
    var $NomDuDomaine = '';

    // De Qui
    var $From = 'root@localhost';// Mail
    var $FromName = 'Root';// Name
    var $ReplyTo = 'root@localhost';// Reply to
    var $org = 'Localhost'; // Organisation

    // To
    var $To = '';
    // Use : $Bcc = 'mail1,mail2,....';
    var $Bcc = '';// Blind Carbon Copy, invisble e-mails for other receiver
    var $Cc = '';

    // Priorité
    var $Priority = 3;// Priority : 1 urgent, 3 normal, 6 low priority

    // Encodage
    var $ContentType = 'html';// kind of content (text, html...) (txt , html, txt/html)
    var $Encoding = '8bit';// Previous value of quoted-printable
    var $ISO = 'iso-8859-15';
    var $MIME = '1.0';// Mime version
    var $Encode = false;// Encodage
    var $CHARSET = '';

    // Confirmation
    var $Confimation_reception = '';// E-mail for the confirmation

    // The mail content
    var $Sujet = '';
    var $Body = '';
    var $Body_txt = '';
    
    // Attached file(s)
    var $File_joint = array();
    
    // Number tour
    var $Tour = 0;


    //**************************************************************************
    // Parameters of SMTP connection
    //**************************************************************************
    var $Authentification_smtp = false;
    
    var $serveur = '';// SMTP server
    var $port = 25;// SMTP port
    var $login_smtp = '';// SMTP login
    var $mdp_smtp = '';// SMTP password
    var $time_out = 10;// Duration of the connection with server (secondes)
    var $tls = false;// Connection with security ( ssl / tls)


    //**************************************************************************
    // Tempory variables
    //**************************************************************************
    var $smtp_connection = '';// Connection variable
    var $erreur = '';
    var $debug = false;

//------------------------------------------------------------------------------

    //**************************************************************************
    // Fonction to declare the SMTP connection
    //**************************************************************************
    function SMTP($serveur='', $user='', $pass='', $port=25, $NomDuDomaine='', $debug=false){
        if($serveur){
            $this->serveur = $serveur;
        }
        if($user){
            $this->Authentification_smtp = true;
            $this->login_smtp = $user;
            $this->mdp_smtp = $pass;
        }
        $this->port = $port;
        if($NomDuDomaine){
            $this->NomDuDomaine = $NomDuDomaine;
        }
        $this->debug = $debug;
    }


    //**************************************************************************
    // Fonction for the SMTP connection
    //**************************************************************************
    function Connect_SMTP(){
		// Definition du charset
		if(!$this->CHARSET){ $this->CHARSET = mb_internal_encoding(); }
		
        // Connection to the SMTP server
        $this->smtp_connection = fsockopen($this->serveur, // Server
                                     $this->port,          // Port
                                     $num_erreur,    	   // Number of the error
                                     $msg_erreur,    	   // Error message
                                     $this->time_out);     // Duration of the connection (secondes)
        if(!$this->smtp_connection){// Check the connection
            $this->erreur = 'Can&#39; t get the connection to the SMTP server !!!<br />'."\r\n"
            .'Error: '.$num_erreur.'<br />'."\r\n"
            .'Message send: '.$msg_erreur.'<br />'."\r\n";
            return false;
        }
        
        // Delete welcome message
        $reponce = $this->get_smtp_data();
        // Debug
        if($this->debug){
            echo '<div style="color:#993300;">Connection</div>',"\r\n",str_replace("\r\n", '<br />', $reponce['msg']);
        }

        // We change the SMTP server time out, because sometime, the server is slow to reply
        // Windows don't know the function socket_set_time_out, so I check the OS
        if(substr(PHP_OS, 0, 3) !== 'WIN'){
           socket_set_timeout($this->smtp_connection, $this->time_out, 0);
        }
        
        //**********************************************************************
        // EHLO and HELO command
        if($this->NomDuDomaine === ''){// Check the configuration of the domain name
            if($_SERVER['SERVER_NAME'] !== ''){
                $this->NomDuDomaine = $_SERVER['SERVER_NAME'];
            }else{
                $this->NomDuDomaine = 'localhost.localdomain';
            }
        }

        if(!$this->Commande('EHLO '.$this->NomDuDomaine, 250)){// EHLO command
			// Second EHLO -> HELO
            if(!$this->Commande('HELO '.$this->NomDuDomaine, 250, 'The server didn&#39;t accept the authentification (EHLO et HELO) !!!')){// HELO command
                return false;
            }
        }
        
        if($this->tls && !$this->Commande('STARTTLS', 220, 'Le serveur refuse la connection sécurisée ( STARTTLS ) !!!')){// Commande STARTTLS
            return false;
        }
        
        if($this->Authentification_smtp){// We check if we need authntification
            //******************************************************************
            // Authentification
            //******************************************************************
            if(!$this->Commande('AUTH LOGIN', 334, 'The server refuse the authentification (AUTH LOGIN) !!!')){
                return false;
            }


            //******************************************************************
            // Authentification : Login
            //******************************************************************
            $tmp = $this->Commande(base64_encode($this->login_smtp), 334, 'Wrong login !!!', 0);
            if(!$tmp['no_error']){
                return false;
            }
            // Debug
            if($this->debug){
                echo '<div style="color:#993300;">Send login.</div>',"\r\n",str_replace("\r\n", '<br />', $tmp['msg']);
            }


            //******************************************************************
            // Authentification : Mot de passe
            //******************************************************************
            $tmp = $this->Commande(base64_encode($this->mdp_smtp), 235, 'Wrong password !!!', 0);
            if(!$tmp['no_error']){
                return false;
            }
            // Debug
            if($this->debug){
                echo '<div style="color:#993300;">Send password.</div>',"\r\n",str_replace("\r\n", '<br />', $tmp['msg']);
            }

        }

        //**********************************************************************
        // Connected to the smtp server
        //**********************************************************************
        return true;
    }


    //**************************************************************************
    // Functions de set
    //**************************************************************************
    function set_from($name, $e-mail='', $org='Localhost'){
		$this->FromName = $name;
		if($this->Encode){
			$this->FromName = encode_mimeheader(mb_convert_encoding($this->FromName, $this->ISO, $this->CHARSET), $this->ISO);
		}
        if(!empty($e-mail)){
            $this->From = $e-mail;
        }
        $this->org = $org;
        unset($name, $e-mail, $org);
    }

    function set_encode($ISO, $CHARSET=''){
		$this->Encode = true;
		$this->ISO = $ISO;
		$this->CHARSET = $CHARSET;
        unset($ISO, $CHARSET);
    }


    //**************************************************************************
    // System d' encodage par Pierre CORBEL
    //**************************************************************************
	function encode_mimeheader($string){
		$encoded = '';
		$CHARSET = mb_internal_encoding();
		// Each line must have length <= 75, including `=?'.$this->CHARSET.'?B?` and `?=`
		$length = 75 - strlen('=?'.$this->CHARSET.'?B?') - 2;
		$tmp = mb_strlen($string, $this->CHARSET);
		// Average multi-byte ratio 
		$ratio = mb_strlen($string, $this->CHARSET) / strlen($string);
		// Base64 has a 4:3 ratio 
		$magic = floor(3 * $length * $ratio / 4)
		$avglength = $magic;
	
		for($i=0; $i <= $tmp; $i+=$magic) {
			$magic = $avglength;
			$offset = 0;
			// Recalculate magic for each line to be 100% sure
			do{
				$magic -= $offset;
				$chunk = mb_substr($string, $i, $magic, $this->CHARSET);
				$chunk = base64_encode($chunk);
				$offset++;
			}while(strlen($chunk) > $length);
			if($chunk){
				$encoded .= ' '.'=?'.$this->CHARSET.'?B?'.$chunk.'?='."\r\n";
			}
		}
		// Chomp the first space and the last linefeed
		return substr($encoded, 1, -2);
	}


    //**************************************************************************
    // Function to add attached file
    //**************************************************************************
    function add_file($url_file){
    	if(!$url_file){
			$this->erreur = 'Missing field !!!<br />'."\r\n";
			return false;
		}
		if(!($fp = @fopen($url_file, 'a'))){
			$this->erreur = 'Can&#39;t find the file !!!<br />'."\r\n";
			return false;
		}
		fclose($fp);
		
		$file_name = explode('/', $url_file);
		$file_name = $file_name[count($file_name)-1];
		$mime = parse_ini_file('./mime.ini');
		$ext = explode('.', $file_name);
		$ext = $ext[count($ext)-1];

		if(IsSet($this->File_joint[$file_name])){
			$file_name = explode('_', str_replace('.'.$ext, '', $file_name));
			if(is_numeric($file_name[count($file_name)-1])){
				$file_name[count($file_name)-1]++;
				$file_name = implode('_', $file_name);
			}else{
				$file_name = implode('_', $file_name);
				$file_name .= '_1';
			}
			$file_name .= '.'.$ext;
		}
		$this->File_joint[$file_name] = array(
										'url' => $url_file,
										'mime' => $mime[$ext]
										);
		unset($file_name, $mime, $ext);
    }


    //**************************************************************************
    // Headers
    //**************************************************************************
    function headers(){
		// Id unique
		$Boundary1 = '------------Boundary-00=_'.substr(md5(uniqid(time())), 0, 7).'0000000000000';
		$Boundary2 = '------------Boundary-00=_'.substr(md5(uniqid(time())), 0, 7).'0000000000000';
		$Boundary3 = '------------Boundary-00=_'.substr(md5(uniqid(time())), 0, 7).'0000000000000';       

        $header = '';
        $No_body = 0;
        
        // Sender e-mail (format : Name <e-mail>)
        if(!empty($this->From)){
            $header .= 'X-Sender: '.$this->From."\n";// Adresse réelle de l'expéditeur
        }
		// Mime version
        if(!empty($this->MIME)){
            $header .= 'MIME-Version: '.$this->MIME."\n";
        }        
        $header .= sprintf("Message-ID: <%s@%s>%s", md5(uniqid(time())), $this->NomDuDomaine, "\n")
        .'Date: '.date('r')."\n"
        .'Content-Type: Multipart/Mixed;'."\n"
        .'  boundary="'.$Boundary1.'"'."\n"
        // Software used to send the mail
		.'X-Mailer: PHP '.phpversion()."\n";
		// Adresse de l'expéditeur (format : Nom <adresse_mail>)
        if(!empty($this->From)){
            if(!empty($this->FromName)){
                $header .= 'From: "'.$this->FromName.'"';
            }else{
                $header .= 'From: ';
            }
            $header .= '<'.$this->From.">\n";
		}
		$header .= 'X-FID: FLAVOR00-NONE-0000-0000-000000000000'."\n";
		
		// Priority of the e-mail : 1 for Urgent, 3 for normal and 6 for low)		
        if(!empty($this->Priority)){
            $header .= 'X-Priority: '.$this->Priority."\n";
        }
		// To	
        if(!empty($this->To)){// To
            $header .= 'To: '.$this->To."\n";
        }else{
            $No_body++;// Nobody
        }
        // Cc
        if(!empty($this->Cc)){// Send copy to
            $header .= 'Cc: '.$this->Cc."\n";
        }else{
            $No_body++;// Nobody
        }
        // Bcc
        if(empty($this->Bcc)){// Blind Carbon Copy, hidden e-mail for other receiver
            $No_body++;// Nobody
        }
        // Subject
        if(!empty($this->Sujet)){
            $header .= 'Subject: '.$this->Sujet."\n";
        }
        if(!empty($this->Confimation_reception)){// Reply to e-mail
            $header .= 'Disposition-Notification-To: <'.$this->Confimation_reception.'>'."\n";
        }
		// ReplyTo
		if(!empty($this->ReplyTo) && $this->ReplyTo !== $this->From && $this->ReplyTo !== 'root@localhost'){// Reply to e-mail
            $header .= 'Reply-to: '.$this->ReplyTo."\n"
            .'Return-Path: <'.$this->ReplyTo.">\n";
        }
        if(!IsSet($_SERVER['REMOTE_ADDR'])){$_SERVER['REMOTE_ADDR'] = '127.0.0.1';}
        if(!IsSet($_SERVER['HTTP_X_FORWARDED_FOR'])){$_SERVER['HTTP_X_FORWARDED_FOR'] = '';}
        if(!IsSet($_SERVER['HTTP_USER_AGENT'])){$_SERVER['HTTP_USER_AGENT'] = 'Internet Explorer';}
        if(!IsSet($_SERVER['HTTP_ACCEPT_LANGUAGE'])){$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'Fr-fr';}
        $host = 'localhost';
        if(function_exists('gethostbyaddr') && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1'){$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);}
        $header .= 'X-Client-IP: '.$_SERVER['REMOTE_ADDR']."\n"
		.'X-Client-PROXY: '.$_SERVER['HTTP_X_FORWARDED_FOR']."\n"
		.'X-Client-Agent: '.$_SERVER['HTTP_USER_AGENT']."\n"
		.'X-Client-Host: '.$host."\n"
		.'X-Client-Language: '.$_SERVER['HTTP_ACCEPT_LANGUAGE']."\n"
		.'Organization: '.$this->org."\n"
		."\n\n\n"
		.'--'.$Boundary1."\n"
		.'Content-Type: Multipart/Alternative;'."\n"
		.'  boundary="'.$Boundary3.'"'."\n"
		."\n\n"
		.'--'.$Boundary3."\n";
		if($this->ContentType === 'txt' || $this->ContentType === 'txt/html'){
			$header .= 'Content-Type: Text/Plain;'."\r\n"
			.'  charset="'.$this->ISO.'"'."\r\n"
			.'Content-Transfer-Encoding: '.$this->Encoding."\r\n"
			."\r\n";
			if($this->ContentType === 'txt'){
				$header .= $this->Body."\r\n";
			}else{
				$header .= $this->Body_txt."\r\n";
			}
		}elseif($this->ContentType === 'html' || $this->ContentType === 'txt/html'){
			if($this->ContentType === 'txt/html'){
				$header .= '--'.$Boundary3."\r\n";
			}
			$header .= 'Content-Type: Text/HTML;'."\r\n"
			.'  charset="'.$this->ISO.'"'."\r\n"
			.'Content-Transfer-Encoding: '.$this->Encoding."\r\n"
			."\r\n"
			.'<html><head>'."\r\n"
			.'<meta http-equiv="Content-LANGUAGE" content="French" />'."\r\n"
			.'<meta http-equiv="Content-Type" content="text/html; charset='.$this->ISO.'" />'."\r\n"
			.'</head>'."\r\n"
			.'<body>'."\r\n"
			.$this->Body."\r\n"
			.'</body></html>'."\r\n"
			.'--'.$Boundary3.'--'."\r\n";
		}else{
			$header .= 'Content-Type: '.$this->ContentType.';'."\r\n"
			.'  charset="'.$this->ISO.'"'."\r\n"
			.'Content-Transfer-Encoding: '.$this->Encoding."\r\n"
			."\r\n"
			.$this->Body."\r\n";	
		}
		$header .= "\n";
		
		// Attach file(s)
		if($this->File_joint){
			foreach($this->File_joint as $file_name => $file){
		        $header .= '--'.$Boundary1."\n"
				.'Content-Type: '.$file['mime'].';'."\n"
				.'  name="'.$file_name.'"'."\n"
				.'Content-Disposition: attachment'."\n"
				.'Content-Transfer-Encoding: base64'."\n"
				."\n"
				.chunk_split(base64_encode(file_get_contents($file['url'])))."\n"
				."\n\n";
			}
		}
		$header .= '--'.$Boundary1.'--';
        
        if($No_body === 3){
            $this->erreur = 'No receiver for this e-mail';
            return false;
        }
        return $header;
    }


    //**************************************************************************
    // Send e-mail with the SMTP server
    //**************************************************************************
    function smtp_mail($to, $subject, $message, $header=''){
        // No automatic disconnect
        $auto_disconnect = false;
        // Check connection
        if(empty($this->smtp_connection)){
            if(!$this->Connect_SMTP()){// Connection
                $this->erreur .= 'Can&#39;t send the e-mail !!!<br />'."\r\n";
                return false;
            }
            $auto_disconnect = true;// Auto disconnect activate
        }
        
        // We check that's the first turn, else we remove the previous parameters
        if($this->Tour){
            if($this->Commande('RSET', 250, 'Can&#39;t send the e-mail !!!')){
                $this->Tour = 0;
            }
        }
        
        //**********************************************************************
        // Temporary modified Variables
        if(!empty($to)){
            $this->To = $to;
        }
        if(!empty($subject)){
			if($this->Encode){
				$this->Sujet = $this->encode_mimeheader(mb_convert_encoding($subject, $this->ISO, $this->CHARSET), $this->ISO);
			}else{
				$this->Sujet = mb_encode_mimeheader($subject, $this->ISO);
			}
        }
        
        if(is_array($message)){
			$this->Body = $message[0];
			$this->Body_txt = $message[1];
			if($this->Encode){
				$this->Body = mb_convert_encoding($this->Body, $this->ISO, $this->CHARSET);
				$this->Body_txt = mb_convert_encoding($this->Body_txt, $this->ISO, $this->CHARSET);
			}
		}else{
        	$this->Body = $message;
			if($this->Encode){
				$this->Body = mb_convert_encoding($this->Body, $this->ISO, $this->CHARSET);
			}
        }

        //**********************************************************************
        // Is there a receiver ?
        if(empty($this->To) && empty($header) && empty($this->Bcc) && empty($this->Cc)){
            $this->erreur = 'No receiver e-mail !!!<br />'."\r\n";
            return false;
        }
        
        //**********************************************************************
        // Send informations
        //**********************************************************************

        //**********************************************************************
        // From
        if(!empty($this->From) && !$this->Tour){
            if(!$this->Commande('MAIL FROM:<'.$this->From.'>', 250, 'Can&#39;t send e-mail, the server doesn&#39;t accept the MAIL FROM command !!!')){
                return false;
            }
            $this->Tour = 1;
        }

        //**********************************************************************
        // To
        $A = array();
        if(!empty($this->To)){
            $A[0] = $this->To;
        }
        if(!empty($this->Bcc)){
            $A[1] = $this->Bcc;
        }
        if(!empty($this->Cc)){
            $A[2] = $this->Cc;
        }
        foreach($A as $cle => $tmp_to){
            if(substr_count($tmp_to, ',')){
                $tmp_to = explode(',', $tmp_to);
                foreach($tmp_to as $cle => $tmp_A){
                    if(!$this->Commande('RCPT TO:<'.$tmp_A.'>', array(250,251), 'Can&#39;t send e-mail, the server doesn&#39;t accept the RCPT TO command !!!')){
                        return false;
                    }
                }
            }else{
                if(!$this->Commande('RCPT TO:<'.$tmp_to.'>', array(250,251), 'Can&#39;t send e-mail, the server doesn&#39;t accept the RCPT TO command !!!')){
                    return false;
                }
            }
        }
        
        //**********************************************************************
        // We create header if it is not already done
        if(empty($header)){
            if(!$header = $this->headers()){
                $this->erreur .= 'Can&#39;t send e-mail !!!<br />'."\r\n";
                return false;
            }
        }


        //**********************************************************************
        // We advice the server that we are sending data
        if(!$this->Commande('DATA', 354, 'Can&#39;t send email, the server doesn&#39;t accept DATA command !!!')){
            return false;
        }


        //**********************************************************************
        // Send the header and the message
        fputs($this->smtp_connection, $header);
        fputs($this->smtp_connection, "\r\n.\r\n");

        $reponce = $this->get_smtp_data();
        // Debug
        if($this->debug){
            echo '<div style="color:#993300;">Header and message :<br />',"\r\n",'<div style="padding-left:25px;">',str_replace(array("\r\n","\n"), '<br />', $header),'<br />',"\r\n",$message,'</div>',"\r\n",'</div>',"\r\n",str_replace("\r\n", '<br />', $reponce['msg']);
        }
        if($reponce['code'] !== 250 && $reponce['code'] !== 354){
            $this->erreur = 'Can&#39;t send the email !!!<br />'."\r\n"
            .'Error code: '.$reponce['code'].'<br />'."\r\n"
            .'Feed back message: '.$reponce['msg'].'<br />'."\r\n";
            return false;
        }


        //**********************************************************************
        // Temporary modified variables
        if($to === $this->To){
            $this->To = '';
        }
        if($subject === $this->Sujet){
            $this->Sujet = '';
        }

        //**********************************************************************
        // Automatique disconnection
        //**********************************************************************
        if($auto_disconnect){// Auto Disconnection ?
            $this->Deconnection_SMTP();// Déconnection
        }

        //**********************************************************************
        // Sended email
        //**********************************************************************
        return true;
    }


    //**************************************************************************
    // Read information return by the SMTP server
    //**************************************************************************
    function get_smtp_data(){
        $data = '';
        while($donnees = fgets($this->smtp_connection, 515)){// On parcour les données renvoyées
            $data .= $donnees;

            if(substr($donnees,3,1) == ' ' && !empty($data)){break;}// On vérifi si on a toutes les données
        }
        // Retun informations : array(Code, message)
        return array('code'=>(int)substr($data, 0, 3), 'msg'=>$data);
    }


    //**************************************************************************
    // Execution SMTP commands
    //**************************************************************************
    function Commande($commande, $bad_error, $msg_error='', $debug=1){
        if(!empty($this->smtp_connection)){
            fputs($this->smtp_connection, $commande."\n");
            $reponce = $this->get_smtp_data();
            // Debug
            if($this->debug && $debug){
                echo '<div style="color:#993300;">',htmlentities($commande),'</div>',"\r\n",str_replace("\r\n", '<br />', $reponce['msg']);
            }

            // Table of valid code
            if((is_array($bad_error) && !in_array($reponce['code'], $bad_error)) || (!is_array($bad_error) && $reponce['code'] !== $bad_error)){
                if($msg_error){
                    $this->erreur = $msg_error.'<br />'."\r\n"
                    .'Code error: '.$reponce['code'].'<br />'."\r\n"
                    .'Returned message: '.$reponce['msg'].'<br />'."\r\n";
                }
                if(!$debug){
                    return array('no_error'=>false, 'msg'=>$reponce['msg']);
                }else{
                    return false;
                }
            }

            if(!$debug){
                return array('no_error'=>true, 'msg'=>$reponce['msg']);
            }else{
                return true;
            }
        }else{
            $this->erreur = 'Can&#39;t execute the command <span style="font-weight:bolder;">'.$commande.'</span> because there is no connection !!!<br />'."\r\n";
            if(!$debug){
                return array('no_error'=>false, 'msg'=>'');
            }else{
                return false;
            }
        }
    }


    //**************************************************************************
    // SMTP disconnection function
    //**************************************************************************
    function Deconnection_SMTP(){
        if(!empty($this->smtp_connection)){
            if(!$this->Commande('QUIT', 221, 'Can&#39;t disconnect !!!')){
                return false;
            }

            @sleep(5);// We wait 5 seconds before terminate all command
            if(!fclose($this->smtp_connection)){
                $this->erreur = 'Can&#39;t disconnect !!!<br />'."\r\n";
                return false;
            }
            $this->smtp_connection = 0;
            return true;
        }
        $this->erreur = 'We can&#39;t disconnect because there is no connection !!!<br />'."\r\n";
        return false;
    }
}
?>