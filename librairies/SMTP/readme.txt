Class d' envoie de mail en smtp-------------------------------
Url     : http://codes-sources.commentcamarche.net/source/37399-class-d-envoie-de-mail-en-smtpAuteur  : ImmortalPCDate    : 07/08/2013
Licence :
=========

Ce document intitulé « Class d' envoie de mail en smtp » issu de CommentCaMarche
(codes-sources.commentcamarche.net) est mis à disposition sous les termes de
la licence Creative Commons. Vous pouvez copier, modifier des copies de cette
source, dans les conditions fixées par la licence, tant que cette note
apparaît clairement.

Description :
=============

Voil&agrave; une class SMTP assez complete.
<br />- Possibilit&eacute; de s' in
dentifier
<br />- Possibilit&eacute; de rentrer les ent&ecirc;tes(header) manue
lement
<br />- Possibilit&eacute; de maintenir la conntection smtp
<br />- Pos
sibilit&eacute; d' ajouter des pi&egrave;ces jointes
<br />- Possibilit&eacute;
 du choix de l' encodage
<br />
<br />Types de champs support&eacute;s :
<br 
/>- To
<br />- Cc
<br />- Bcc
<br />
<br />En version simple, le code d' env
oie fait 3 lignes !!!
<br />La version Anglaise est disponible. (traduction fai
te par Pierre CORBEL : <a href='http://www.some-ideas.net/' target='_blank'>http
://www.some-ideas.net/</a> )
<br /><a name='source-exemple'></a><h2> Source / E
xemple : </h2>
<br /><pre class='code' data-mode='basic'>
&lt;?php
/********
***********************************************************************
*

<u
l><li> Nom de la source :
</li><li>       Class SMTP
</li><li> Nom du fichier 
par défaut :
</li><li>       Class.SMTP.php
</li><li> Auteur :
</li><li>     
  Nuel Guillaume alias Immortal-PC
</li><li> Site Web :
</li><li>       <a hre
f='http://immortal-pc.info/' target='_blank'>http://immortal-pc.info/</a></li></
ul>
*

<ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><l
i><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><l
i><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><l
i><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><l
i><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><l
i><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><l
i><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><l
i><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><li><ul><l
i>/</li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></
ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></
ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></
ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></
ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></
ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></
ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></
ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></
ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></
ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul>

cla
ss SMTP {
    // Nom du domaine ou nom du serveur
    var $NomDuDomaine = '';


    // De Qui
    var $From = 'root@localhost';// Adresse de l' expéditeur

    var $FromName = 'Root';// Nom de l' expéditeur
    var $ReplyTo = 'root@loc
alhost';// Adresse de retour
    var $org = 'Localhost'; // Organisation

   
 // A Qui
    var $To = '';
    // Utilisation : $Bcc = 'mail1,mail2,....';
 
   var $Bcc = '';// Blind Carbon Copy, c'est à dire que les adresses qui sont co
ntenue ici seront invisibles pour tout le monde
    var $Cc = '';

    // Pri
orité
    var $Priority = 3;// Priorité accordée au mail (valeur allant de 1 po
ur Urgent à 3 pour normal et 6 pour bas)

    // Encodage
    var $ContentTyp
e = 'html';//Contenu du mail (texte, html...) (txt , html, txt/html)
    var $E
ncoding = '8bit'; // Ancienne valeur quoted-printable
    var $ISO = 'iso-8859-
15';
    var $MIME = '1.0';// La version mime
    var $Encode = false;// Encod
age necessaire ou pas
	var $CHARSET = '';

    // Confirmation de reception

    var $Confimation_reception = '';// Entrez l' adresse où sera renvoyé la conf
irmation

    // Le mail
    var $Sujet = '';
    var $Body = '';
    var $
Body_txt = '';
    
    // Fichier(s) joint(s)
    var $File_joint = array();

    
    // Nombre tour
    var $Tour = 0;

    //************************
**************************************************
    // Paramètre de connecti
on SMTP
    //*****************************************************************
*********
    var $Authentification_smtp = false;
    
    var $serveur = '';
// Serveur SMTP
    var $port = 25;// Port SMTP
    var $login_smtp = '';// Lo
gin pour le serveur SMTP
    var $mdp_smtp = '';// Mot de passe pour le serveur
 SMTP
    var $time_out = 10;// Durée de la connection avec le serveur SMTP
  
  var $tls = false;// Activation de la connection sécurisée (anciennement ssl)


    //************************************************************************
**
    // Variables temporaires
    //****************************************
**********************************
    var $smtp_connection = '';// Variable de
 connection
    var $erreur = '';
    var $debug = false;

//---------------
---------------------------------------------------------------

    //*******
*******************************************************************
    // Fonc
tion de déclaration de connection SMTP
    //**********************************
****************************************
    function SMTP($serveur='', $user='
', $pass='', $port=25, $NomDuDomaine='', $debug=false){
        if($serveur){

            $this-&gt;serveur = $serveur;
        }
        if($user){
      
      $this-&gt;Authentification_smtp = true;
            $this-&gt;login_smtp 
= $user;
            $this-&gt;mdp_smtp = $pass;
        }
        $this-&gt;
port = $port;
        if($NomDuDomaine){
            $this-&gt;NomDuDomaine = 
$NomDuDomaine;
        }
        $this-&gt;debug = $debug;
    }

    //***
***********************************************************************
    // 
Fonction de connection SMTP
    //*********************************************
*****************************
    function Connect_SMTP(){
		// Definition du 
charset
		if(!$this-&gt;CHARSET){ $this-&gt;CHARSET = mb_internal_encoding(); }

		
        // Connection au serveur SMTP
        $this-&gt;smtp_connection =
 fsockopen($this-&gt;serveur, // Serveur
                                     $
this-&gt;port,          // Port de connection
                                 
    $num_erreur,    	   // Numéros de l' erreur
                               
      $msg_erreur,    	   // Message d' erreur
                                
     $this-&gt;time_out);     // Durée de la connection en secs
        if(!$th
is-&gt;smtp_connection){// Vérification de la connection
            $this-&gt;
erreur = 'Impossible de se connecter au serveur SMTP !!!&lt;br /&gt;'.&quot;\r\n
&quot;
            .'Numéro de l&amp;#39; erreur: '.$num_erreur.'&lt;br /&gt;'.
&quot;\r\n&quot;
            .'Message renvoyé: '.$msg_erreur.'&lt;br /&gt;'.&q
uot;\r\n&quot;;
            return false;
        }
        
        // Supp
ression du message d' accueil
        $reponce = $this-&gt;get_smtp_data();
  
      // Debug
        if($this-&gt;debug){
            echo '&lt;div style=&q
uot;color:#993300;&quot;&gt;Connection&lt;/div&gt;',&quot;\r\n&quot;,str_replace
(&quot;\r\n&quot;, '&lt;br /&gt;', $reponce['msg']);
        }

        // On
 règle le timeout du serveur SMTP car parfois, le serveur SMTP peut être un peut
 lent à répondre
        // Windows ne comprend pas la fonction socket_set_time
out donc on vérifi que l' on travail sous Linux
        if(substr(PHP_OS, 0, 3)
 !== 'WIN'){
           socket_set_timeout($this-&gt;smtp_connection, $this-&gt
;time_out, 0);
        }
        
        //*********************************
*************************************
        // Commande EHLO et HELO
       
 if($this-&gt;NomDuDomaine === ''){// On vérifit si le nom de domaine à été rens
eigné
            if($_SERVER['SERVER_NAME'] !== ''){
                $this-&g
t;NomDuDomaine = $_SERVER['SERVER_NAME'];
            }else{
                $
this-&gt;NomDuDomaine = 'localhost.localdomain';
            }
        }

  
      if(!$this-&gt;Commande('EHLO '.$this-&gt;NomDuDomaine, 250)){// Commande E
HLO
            // Deusième commande EHLO -&gt; HELO
            if(!$this-&gt
;Commande('HELO '.$this-&gt;NomDuDomaine, 250, 'Le serveur refuse l&amp;#39; aut
hentification (EHLO et HELO) !!!')){// Commande HELO
                return fal
se;
            }
        }

        if($this-&gt;tls &amp;&amp; !$this-&gt;
Commande('STARTTLS', 220, 'Le serveur refuse la connection sécurisée ( STARTTLS 
) !!!')){// Commande STARTTLS
            return false;
        }
        
 
       if($this-&gt;Authentification_smtp){// On vérifi si l' on a besoin de s' 
authentifier
            //****************************************************
**************
            // Authentification
            //*****************
*************************************************
            if(!$this-&gt;Com
mande('AUTH LOGIN', 334, 'Le serveur refuse l&amp;#39; authentification (AUTH LO
GIN) !!!')){
                return false;
            }

            //****
**************************************************************
            // A
uthentification : Login
            //*****************************************
*************************
            $tmp = $this-&gt;Commande(base64_encode($
this-&gt;login_smtp), 334, 'Login ( Nom d&amp;#39; utilisateur ) incorrect !!!',
 0);
            if(!$tmp['no_error']){
                return false;
       
     }
            // Debug
            if($this-&gt;debug){
                
echo '&lt;div style=&quot;color:#993300;&quot;&gt;Envoie du login.&lt;/div&gt;',
&quot;\r\n&quot;,str_replace(&quot;\r\n&quot;, '&lt;br /&gt;', $tmp['msg']);
  
          }

            //***************************************************
***************
            // Authentification : Mot de passe
            //*
*****************************************************************
            $
tmp = $this-&gt;Commande(base64_encode($this-&gt;mdp_smtp), 235, 'Mot de passe i
ncorrect !!!', 0);
            if(!$tmp['no_error']){
                return f
alse;
            }
            // Debug
            if($this-&gt;debug){
  
              echo '&lt;div style=&quot;color:#993300;&quot;&gt;Envoie du mot de
 passe.&lt;/div&gt;',&quot;\r\n&quot;,str_replace(&quot;\r\n&quot;, '&lt;br /&gt
;', $tmp['msg']);
            }

        }

        //*********************
*************************************************
        // Connecté au serveu
r SMTP
        //**************************************************************
********
        return true;
    }

    //*********************************
*****************************************
    // Fonctons de set
    //*******
*******************************************************************
    functio
n set_from($name, $email='', $org='Localhost'){
		$this-&gt;FromName = $name;

		if($this-&gt;Encode){
			$this-&gt;FromName = $this-&gt;encode_mimeheader(mb_
convert_encoding($this-&gt;FromName, $this-&gt;ISO, $this-&gt;CHARSET), $this-&g
t;ISO);
		}
        if(!empty($email)){
            $this-&gt;From = $email;

        }
        $this-&gt;org = $org;
        unset($name, $email, $org);

    }

    function set_encode($ISO, $CHARSET=''){
		$this-&gt;Encode = true;

		$this-&gt;ISO = $ISO;
		$this-&gt;CHARSET = $CHARSET;
        unset($ISO, 
$CHARSET);
    }

    //*****************************************************
*********************
    // System d' encodage par Pierre CORBEL
    //******
********************************************************************
	function 
encode_mimeheader($string){
		$encoded = '';
		$CHARSET = mb_internal_encoding
();
		// Each line must have length &lt;= 75, including `=?'.$this-&gt;CHARSET.
'?B?` and `?=`
		$length = 75 - strlen('=?'.$this-&gt;CHARSET.'?B?') - 2;
		$t
mp = mb_strlen($string, $this-&gt;CHARSET);
		// Average multi-byte ratio 
		$
ratio = mb_strlen($string, $this-&gt;CHARSET) / strlen($string);
		// Base64 ha
s a 4:3 ratio 
		$magic = floor(3 * $length * $ratio / 4);
		$avglength = $mag
ic;
	
		for($i=0; $i &lt;= $tmp; $i+=$magic) {
			$magic = $avglength;
			$o
ffset = 0;
			// Recalculate magic for each line to be 100% sure
			do{
				$
magic -= $offset;
				$chunk = mb_substr($string, $i, $magic, $this-&gt;CHARSET
);
				$chunk = base64_encode($chunk);
				$offset++;
			}while(strlen($chunk
) &gt; $length);
			if($chunk){
				$encoded .= ' '.'=?'.$this-&gt;CHARSET.'?B
?'.$chunk.'?='.&quot;\r\n&quot;;
			}
		}
		// Chomp the first space and the 
last linefeed
		return substr($encoded, 1, -2);
	}

    //******************
********************************************************
    // Foncton d' ajou
t de pièce jointe
    //*******************************************************
*******************
    function add_file($url_file){
    	if(!$url_file){
		
	$this-&gt;erreur = 'Champs manquant !!!&lt;br /&gt;'.&quot;\r\n&quot;;
			retu
rn false;
		}
		if(!($fp = @fopen($url_file, 'a'))){
			$this-&gt;erreur = 'F
ichier introuvable !!!&lt;br /&gt;'.&quot;\r\n&quot;;
			return false;
		}
		
fclose($fp);
		
		$file_name = explode('/', $url_file);
		$file_name = $file_
name[count($file_name)-1];
		$mime = parse_ini_file('./mime.ini');
		$ext = ex
plode('.', $file_name);
		$ext = $ext[count($ext)-1];

		if(IsSet($this-&gt;F
ile_joint[$file_name])){
			$file_name = explode('_', str_replace('.'.$ext, '',
 $file_name));
			if(is_numeric($file_name[count($file_name)-1])){
				$file_n
ame[count($file_name)-1]++;
				$file_name = implode('_', $file_name);
			}els
e{
				$file_name = implode('_', $file_name);
				$file_name .= '_1';
			}
	
		$file_name .= '.'.$ext;
		}
		$this-&gt;File_joint[$file_name] = array(
			
							'url' =&gt; $url_file,
										'mime' =&gt; $mime[$ext]
										);

		unset($file_name, $mime, $ext);
    }

    //*****************************
*********************************************
    // Entêtes (Headers)
    //*
*************************************************************************
    f
unction headers(){
		// Id unique
		$Boundary1 = '------------Boundary-00=_'.s
ubstr(md5(uniqid(time())), 0, 7).'0000000000000';
		$Boundary2 = '------------B
oundary-00=_'.substr(md5(uniqid(time())), 0, 7).'0000000000000';
		$Boundary3 =
 '------------Boundary-00=_'.substr(md5(uniqid(time())), 0, 7).'0000000000000'; 
      

        $header = '';
        $No_body = 0;
        
        // Adr
esse de l'expéditeur (format : Nom &lt;adresse_mail&gt;)
        if(!empty($thi
s-&gt;From)){
            $header .= 'X-Sender: '.$this-&gt;From.&quot;\n&quot;
;// Adresse réelle de l'expéditeur
        }
		// La version mime
        if(
!empty($this-&gt;MIME)){
            $header .= 'MIME-Version: '.$this-&gt;MIME
.&quot;\n&quot;;
        }
        $header .= sprintf(&quot;Message-ID: &lt;%s
@%s&gt;%s&quot;, md5(uniqid(time())), $this-&gt;NomDuDomaine, &quot;\n&quot;)
 
       .'Date: '.date('r').&quot;\n&quot;
        .'Content-Type: Multipart/Mix
ed;'.&quot;\n&quot;
        .'  boundary=&quot;'.$Boundary1.'&quot;'.&quot;\n&q
uot;
        // Logiciel utilisé pour l' envoi des mails
		.'X-Mailer: PHP '.p
hpversion().&quot;\n&quot;;
		// Adresse de l'expéditeur (format : Nom &lt;adre
sse_mail&gt;)
        if(!empty($this-&gt;From)){
            if(!empty($this-
&gt;FromName)){
                $header .= 'From: &quot;'.$this-&gt;FromName.'&
quot;';
            }else{
                $header .= 'From: ';
            }

            $header .= '&lt;'.$this-&gt;From.&quot;&gt;\n&quot;;
		}
		$head
er .= 'X-FID: FLAVOR00-NONE-0000-0000-000000000000'.&quot;\n&quot;;
		
		// Pr
iorité accordée au mail (valeur allant de 1 pour Urgent à 3 pour normal et 6 pou
r bas)		
        if(!empty($this-&gt;Priority)){
            $header .= 'X-Pri
ority: '.$this-&gt;Priority.&quot;\n&quot;;
        }
		// To	
        if(!em
pty($this-&gt;To)){// A
            $header .= 'To: '.$this-&gt;To.&quot;\n&quo
t;;
        }else{
            $No_body++;// Personne
        }
        // C
c
        if(!empty($this-&gt;Cc)){// Copie du mail
            $header .= 'Cc
: '.$this-&gt;Cc.&quot;\n&quot;;
        }else{
            $No_body++;// Pers
onne
        }
        // Bcc
        if(empty($this-&gt;Bcc)){// Blind Carbo
n Copy, c' est à dire que les adresses qui sont contenue ici seront invisibles p
our tout le monde
            $No_body++;// Personne
        }
        // Suj
et
        if(!empty($this-&gt;Sujet)){
            $header .= 'Subject: '.$th
is-&gt;Sujet.&quot;\n&quot;;
        }
        if(!empty($this-&gt;Confimation
_reception)){// Adresse utilisée pour la réponse au mail
            $header .=
 'Disposition-Notification-To: &lt;'.$this-&gt;Confimation_reception.'&gt;'.&quo
t;\n&quot;;
        }
		// ReplyTo
		if(!empty($this-&gt;ReplyTo) &amp;&amp; 
$this-&gt;ReplyTo !== $this-&gt;From &amp;&amp; $this-&gt;ReplyTo !== 'root@loca
lhost'){// Adresse utilisée pour la réponse au mail
            $header .= 'Rep
ly-to: '.$this-&gt;ReplyTo.&quot;\n&quot;
            .'Return-Path: &lt;'.$thi
s-&gt;ReplyTo.&quot;&gt;\n&quot;;
        }
        if(!IsSet($_SERVER['REMOTE
_ADDR'])){$_SERVER['REMOTE_ADDR'] = '127.0.0.1';}
        if(!IsSet($_SERVER['H
TTP_X_FORWARDED_FOR'])){$_SERVER['HTTP_X_FORWARDED_FOR'] = '';}
        if(!IsS
et($_SERVER['HTTP_USER_AGENT'])){$_SERVER['HTTP_USER_AGENT'] = 'Internet Explore
r';}
        if(!IsSet($_SERVER['HTTP_ACCEPT_LANGUAGE'])){$_SERVER['HTTP_ACCEPT
_LANGUAGE'] = 'Fr-fr';}
        $host = 'localhost';
        if(function_exist
s('gethostbyaddr') &amp;&amp; $_SERVER['REMOTE_ADDR'] !== '127.0.0.1'){$host = g
ethostbyaddr($_SERVER['REMOTE_ADDR']);}
        $header .= 'X-Client-IP: '.$_SE
RVER['REMOTE_ADDR'].&quot;\n&quot;
		.'X-Client-PROXY: '.$_SERVER['HTTP_X_FORWA
RDED_FOR'].&quot;\n&quot;
		.'X-Client-Agent: '.$_SERVER['HTTP_USER_AGENT'].&qu
ot;\n&quot;
		.'X-Client-Host: '.$host.&quot;\n&quot;
		.'X-Client-Language: '
.$_SERVER['HTTP_ACCEPT_LANGUAGE'].&quot;\n&quot;
		.'Organization: '.$this-&gt;
org.&quot;\n&quot;
		.&quot;\n\n\n&quot;
		.'--'.$Boundary1.&quot;\n&quot;
		
.'Content-Type: Multipart/Alternative;'.&quot;\n&quot;
		.'  boundary=&quot;'.$
Boundary3.'&quot;'.&quot;\n&quot;
		.&quot;\n\n&quot;
		.'--'.$Boundary3.&quot
;\n&quot;;
		if($this-&gt;ContentType === 'txt' || $this-&gt;ContentType === 't
xt/html'){
			$header .= 'Content-Type: Text/Plain;'.&quot;\r\n&quot;
			.'  c
harset=&quot;'.$this-&gt;ISO.'&quot;'.&quot;\r\n&quot;
			.'Content-Transfer-En
coding: '.$this-&gt;Encoding.&quot;\r\n&quot;
			.&quot;\r\n&quot;;
			if($thi
s-&gt;ContentType === 'txt'){
				$header .= $this-&gt;Body.&quot;\r\n&quot;;

			}else{
				$header .= $this-&gt;Body_txt.&quot;\r\n&quot;;
			}
		}elseif(
$this-&gt;ContentType === 'html' || $this-&gt;ContentType === 'txt/html'){
			i
f($this-&gt;ContentType === 'txt/html'){
				$header .= '--'.$Boundary3.&quot;\
r\n&quot;;
			}
			$header .= 'Content-Type: Text/HTML;'.&quot;\r\n&quot;
			
.'  charset=&quot;'.$this-&gt;ISO.'&quot;'.&quot;\r\n&quot;
			.'Content-Transf
er-Encoding: '.$this-&gt;Encoding.&quot;\r\n&quot;
			.&quot;\r\n&quot;
			.'&
lt;html&gt;&lt;head&gt;'.&quot;\r\n&quot;
			.'&lt;meta http-equiv=&quot;Conten
t-LANGUAGE&quot; content=&quot;French&quot; /&gt;'.&quot;\r\n&quot;
			.'&lt;me
ta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset='.$this-
&gt;ISO.'&quot; /&gt;'.&quot;\r\n&quot;
			.'&lt;/head&gt;'.&quot;\r\n&quot;
	
		.'&lt;body&gt;'.&quot;\r\n&quot;
			.$this-&gt;Body.&quot;\r\n&quot;
			.'&l
t;/body&gt;&lt;/html&gt;'.&quot;\r\n&quot;
			.'--'.$Boundary3.'--'.&quot;\r\n&
quot;;
		}else{
			$header .= 'Content-Type: '.$this-&gt;ContentType.';'.&quot
;\r\n&quot;
			.'  charset=&quot;'.$this-&gt;ISO.'&quot;'.&quot;\r\n&quot;
			
.'Content-Transfer-Encoding: '.$this-&gt;Encoding.&quot;\r\n&quot;
			.&quot;\r
\n&quot;
			.$this-&gt;Body.&quot;\r\n&quot;;	
		}
		$header .= &quot;\n&quot
;;
		
		// On joint le ou les fichiers
		if($this-&gt;File_joint){
			foreac
h($this-&gt;File_joint as $file_name =&gt; $file){
		        $header .= '--'.$B
oundary1.&quot;\n&quot;
				.'Content-Type: '.$file['mime'].';'.&quot;\n&quot;

				.'  name=&quot;'.$file_name.'&quot;'.&quot;\n&quot;
				.'Content-Disposit
ion: attachment'.&quot;\n&quot;
				.'Content-Transfer-Encoding: base64'.&quot;
\n&quot;
				.&quot;\n&quot;
				.chunk_split(base64_encode(file_get_contents(
$file['url']))).&quot;\n&quot;
				.&quot;\n\n&quot;;
			}
		}
		$header .= 
'--'.$Boundary1.'--';
        
        if($No_body === 3){
            $this-
&gt;erreur = 'Le mail n&amp;#39; a pas de destinataire !!!';
            return
 false;
        }
        return $header;
    }

    //********************
******************************************************
    // Envoie du mail av
ec le serveur SMTP
    //******************************************************
********************
    function smtp_mail($to, $subject, $message, $header=''
){
        // Pas de déconnection automatique
        $auto_disconnect = false
;
        // On vérifit si la connection existe
        if(empty($this-&gt;smt
p_connection)){
            if(!$this-&gt;Connect_SMTP()){// Connection
      
          $this-&gt;erreur .= 'Impossible d&amp;#39; envoyer le mail !!!&lt;br /
&gt;'.&quot;\r\n&quot;;
                return false;
            }
         
   $auto_disconnect = true;// Déconnection automatique activée
        }
     
   
        // On vérifit Que c' est le premier tour sinon on éfface les ancien
s paramètres
        if($this-&gt;Tour){
            if($this-&gt;Commande('RS
ET', 250, 'Envoie du mail impossible !!!')){
                $this-&gt;Tour = 0
;
            }
        }
        
        //*******************************
***************************************
        // Variables temporairement mod
ifiées
        if(!empty($to)){
            $this-&gt;To = $to;
        }
  
      if(!empty($subject)){
			if($this-&gt;Encode){
				$this-&gt;Sujet = $th
is-&gt;encode_mimeheader(mb_convert_encoding($subject, $this-&gt;ISO, $this-&gt;
CHARSET), $this-&gt;ISO);
			}else{
				$this-&gt;Sujet = mb_encode_mimeheader
($subject, $this-&gt;ISO);
			}
        }
        
        if(is_array($mess
age)){
			$this-&gt;Body = $message[0];
			$this-&gt;Body_txt = $message[1];

			if($this-&gt;Encode){
				$this-&gt;Body = mb_convert_encoding($this-&gt;Bod
y, $this-&gt;ISO, $this-&gt;CHARSET);
				$this-&gt;Body_txt = mb_convert_encod
ing($this-&gt;Body_txt, $this-&gt;ISO, $this-&gt;CHARSET);
			}
		}else{
    
    	$this-&gt;Body = $message;
			if($this-&gt;Encode){
				$this-&gt;Body = 
mb_convert_encoding($this-&gt;Body, $this-&gt;ISO, $this-&gt;CHARSET);
			}
  
      }

        //***********************************************************
***********
        // Y a t' il un destinataire
        if(empty($this-&gt;To
) &amp;&amp; empty($header) &amp;&amp; empty($this-&gt;Bcc) &amp;&amp; empty($th
is-&gt;Cc)){
            $this-&gt;erreur = 'Veuillez entrer une adresse de des
tination !!!&lt;br /&gt;'.&quot;\r\n&quot;;
            return false;
        
}
        
        //*********************************************************
*************
        // Envoie des informations
        //*******************
***************************************************

        //***************
*******************************************************
        // De Qui
    
    if(!empty($this-&gt;From) &amp;&amp; !$this-&gt;Tour){
            if(!$thi
s-&gt;Commande('MAIL FROM:&lt;'.$this-&gt;From.'&gt;', 250, 'Envoie du mail impo
ssible car le serveur n&amp;#39; accèpte pas la commande MAIL FROM !!!')){
    
            return false;
            }
            $this-&gt;Tour = 1;
     
   }

        //**************************************************************
********
        // A Qui
        $A = array();
        if(!empty($this-&gt;T
o)){
            $A[0] = $this-&gt;To;
        }
        if(!empty($this-&gt;
Bcc)){
            $A[1] = $this-&gt;Bcc;
        }
        if(!empty($this-&
gt;Cc)){
            $A[2] = $this-&gt;Cc;
        }
        foreach($A as $c
le =&gt; $tmp_to){
            if(substr_count($tmp_to, ',')){
               
 $tmp_to = explode(',', $tmp_to);
                foreach($tmp_to as $cle =&gt;
 $tmp_A){
                    if(!$this-&gt;Commande('RCPT TO:&lt;'.$tmp_A.'&gt
;', array(250,251), 'Envoie du mail impossible car le serveur n&amp;#39; accèpte
 pas la commande RCPT TO !!!')){
                        return false;
       
             }
                }
            }else{
                if(!$this
-&gt;Commande('RCPT TO:&lt;'.$tmp_to.'&gt;', array(250,251), 'Envoie du mail imp
ossible car le serveur n&amp;#39; accèpte pas la commande RCPT TO !!!')){
     
               return false;
                }
            }
        }
     
   
        //*****************************************************************
*****
        // On créer les entêtes ( headers ) si c' est pas fait
        i
f(empty($header)){
            if(!$header = $this-&gt;headers()){
           
     $this-&gt;erreur .= 'Impossible d&amp;#39; envoyer le mail !!!&lt;br /&gt;'
.&quot;\r\n&quot;;
                return false;
            }
        }

 
       //**********************************************************************

        // On indique que l' on va envoyer des données
        if(!$this-&gt;C
ommande('DATA', 354, 'Envoie du mail impossible car le serveur n&amp;#39; accèpt
e pas la commande DATA!!!')){
            return false;
        }

        /
/**********************************************************************
       
 // Envoie de l' entête et du message
        fputs($this-&gt;smtp_connection, 
$header);
        fputs($this-&gt;smtp_connection, &quot;\r\n.\r\n&quot;);

 
       $reponce = $this-&gt;get_smtp_data();
        // Debug
        if($this
-&gt;debug){
            echo '&lt;div style=&quot;color:#993300;&quot;&gt;Entê
te et message :&lt;br /&gt;',&quot;\r\n&quot;,'&lt;div style=&quot;padding-left:
25px;&quot;&gt;',str_replace(array(&quot;\r\n&quot;,&quot;\n&quot;), '&lt;br /&g
t;', $header),'&lt;br /&gt;',&quot;\r\n&quot;,$message,'&lt;/div&gt;',&quot;\r\n
&quot;,'&lt;/div&gt;',&quot;\r\n&quot;,str_replace(&quot;\r\n&quot;, '&lt;br /&g
t;', $reponce['msg']);
        }
        if($reponce['code'] !== 250 &amp;&amp
; $reponce['code'] !== 354){
            $this-&gt;erreur = 'Envoie du mail imp
ossible !!!&lt;br /&gt;'.&quot;\r\n&quot;
            .'Numéro de l&amp;#39; er
reur: '.$reponce['code'].'&lt;br /&gt;'.&quot;\r\n&quot;
            .'Message 
renvoyé: '.$reponce['msg'].'&lt;br /&gt;'.&quot;\r\n&quot;;
            return 
false;
        }

        //*************************************************
*********************
        // Variables temporairement modifiées
        if
($to === $this-&gt;To){
            $this-&gt;To = '';
        }
        if($
subject === $this-&gt;Sujet){
            $this-&gt;Sujet = '';
        }

 
       //**********************************************************************

        // Déconnection automatique
        //********************************
**************************************
        if($auto_disconnect){// Auto déc
onnection ?
            $this-&gt;Deconnection_SMTP();// Déconnection
        
}

        //*****************************************************************
*****
        // Mail envoyé
        //***************************************
*******************************
        return true;
    }

    //**********
****************************************************************
    // Lecture
 des données renvoyées par le serveur SMTP
    //******************************
********************************************
    function get_smtp_data(){
   
     $data = '';
        while($donnees = fgets($this-&gt;smtp_connection, 515)
){// On parcour les données renvoyées
            $data .= $donnees;

       
     if(substr($donnees,3,1) == ' ' &amp;&amp; !empty($data)){break;}// On vérif
i si on a toutes les données
        }
        // Renvoie des données : array(
Code, message complet)
        return array('code'=&gt;(int)substr($data, 0, 3)
, 'msg'=&gt;$data);
    }

    //********************************************
******************************
    // Execution des commandes SMTP
    //*****
*********************************************************************
    funct
ion Commande($commande, $bad_error, $msg_error='', $debug=1){
        if(!empty
($this-&gt;smtp_connection)){
            fputs($this-&gt;smtp_connection, $com
mande.&quot;\n&quot;);
            $reponce = $this-&gt;get_smtp_data();
     
       // Debug
            if($this-&gt;debug &amp;&amp; $debug){
           
     echo '&lt;div style=&quot;color:#993300;&quot;&gt;',htmlentities($commande)
,'&lt;/div&gt;',&quot;\r\n&quot;,str_replace(&quot;\r\n&quot;, '&lt;br /&gt;', $
reponce['msg']);
            }

            // Tableau de code valide
      
      if((is_array($bad_error) &amp;&amp; !in_array($reponce['code'], $bad_error
)) || (!is_array($bad_error) &amp;&amp; $reponce['code'] !== $bad_error)){
    
            if($msg_error){
                    $this-&gt;erreur = $msg_error.'
&lt;br /&gt;'.&quot;\r\n&quot;
                    .'Numéro de l&amp;#39; erreu
r: '.$reponce['code'].'&lt;br /&gt;'.&quot;\r\n&quot;
                    .'Mes
sage renvoyé: '.$reponce['msg'].'&lt;br /&gt;'.&quot;\r\n&quot;;
              
  }
                if(!$debug){
                    return array('no_error'=&
gt;false, 'msg'=&gt;$reponce['msg']);
                }else{
                 
   return false;
                }
            }

            if(!$debug){

                return array('no_error'=&gt;true, 'msg'=&gt;$reponce['msg']);
 
           }else{
                return true;
            }
        }else{

            $this-&gt;erreur = 'Impossible d&amp;#39; éxecuter la commande &lt;s
pan style=&quot;font-weight:bolder;&quot;&gt;'.$commande.'&lt;/span&gt; car il n
&amp;#39; y a pas de connection !!!&lt;br /&gt;'.&quot;\r\n&quot;;
            
if(!$debug){
                return array('no_error'=&gt;false, 'msg'=&gt;'');

            }else{
                return false;
            }
        }
  
  }

    //*******************************************************************
*******
    // Fonction de déconnection SMTP
    //***************************
***********************************************
    function Deconnection_SMTP(
){
        if(!empty($this-&gt;smtp_connection)){
            if(!$this-&gt;Co
mmande('QUIT', 221, 'Impossible de se déconnecter !!!')){
                retur
n false;
            }

            @sleep(5);// On laisse 5 seconde au serve
ur pour terminer toutes les instructions
            if(!fclose($this-&gt;smtp_
connection)){
                $this-&gt;erreur = 'Impossible de se déconnecter 
!!!&lt;br /&gt;'.&quot;\r\n&quot;;
                return false;
            }

            $this-&gt;smtp_connection = 0;
            return true;          
  
        }
        $this-&gt;erreur = 'Impossible de se déconnecter car il n
&amp;#39; y a pas de connection !!!&lt;br /&gt;'.&quot;\r\n&quot;;
        retu
rn false;
    }
}
?&gt;
</pre>
<br /><a name='conclusion'></a><h2> Conclusi
on : </h2>
<br />Pour envoyer un mail :
<br />&lt;?php
<br />include('./Clas
s.SMTP.php');
<br />
<br />// Remplissez le champs login et pass si vous avez 
besoin de vous identifier
<br />// SMTP('smtp.serveur.fr', 'login', 'pass');
<
br />
<br />// SMTP sans authentification
<br />// SMTP('smtp.serveur.fr');
<
br />
<br />$smtp = new SMTP('smtp.serveur.fr', 'login', 'pass');
<br />
<br 
/>$smtp-&gt;smtp_mail('to@you.com', 'sujet', 'message');// Envoie du mail
<br /
>
<br />if(!$smtp-&gt;erreur){
<br />    echo '&lt;div style=&quot;text-align:
center; color:#008000;&quot;&gt;Votre mail a bien &eacute;t&eacute; envoy&eacute
;.&lt;/div&gt;',&quot;\r\n&quot;;
<br />}else{// Affichage des erreurs
<br /> 
   echo $smtp-&gt;erreur;
<br />}
<br />?&gt;
