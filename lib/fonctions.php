<?php
class rateTool {

	//var $rateClass; //Tableau contenant les erreurs d�tect�es
  	var $rateSelected; //Variable contenant le nombre d'erreurs d�tect�es
  	
  	//Constructeur de la classe ici on passe en param�tre le nom du style d'erreur par defaut.
  	function rateTool()	{
  	
	}
	
	function init(){
		//$this->rateClass = array('1' => 'rating_off', '2' => 'rating_off', '3' => 'rating_off', '4' => 'rating_off', '5' => 'rating_off');
		$this->rateSelected = array('1' => '', '2' => '', '3' => '', '4' => '', '5' => '');
	}
	
	function transform($value){
		//for ($i=1; $i<=$value; $i++) {
		//	$this->rateClass[$i] = 'rating_on';
		//}
		$this->rateSelected[$value]='selected';
	}
	
	function getclass($value){
		return $this->rateClass[$value];
	}
	
	function getselected($value){
		return $this->rateSelected[$value];
	}
	
}

// gestion des dates
class dateTools {

  	var $Date1; 
  	var $Day1; 
  	var $Month1; 
  	var $Year1; 
  	
  	var $Date2; 
  	var $Day2; 
  	var $Month2; 
  	var $Year2;
  	
  	// format year-mons-day
  	function dateTools($date1,$date2)	{
  		$this->Date1 = $date1;
   		$this->Date2 = $date2;

   		$tok = strtok($date1,"-");
		$this->Year1 = $tok;
		$tok = strtok("-");
		$this->Month1 = $tok;
		$tok = strtok("-");
		$this->Day1 = $tok;
		
   		$tok = strtok($date2,"-");
		$this->Year2 = $tok;
		$tok = strtok("-");
		$this->Month2 = $tok;
		$tok = strtok("-");
		$this->Day2 = $tok;
  	}
  	
	function changeDATE($nbr) {
		return date("Y-m-d", mktime(0, 0, 0, $this->Month1, $this->Day1 + $nbr, $this->Year1)); 
	}

	function transformDATE() {
		//setlocale(LC_TIME, 'fr');
		setlocale(LC_TIME, 'fr_FR', 'fr', 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
		$date = $this->Month1."/".$this->Day1."/".$this->Year1;
		return ucfirst(strftime('%A, %d %B %Y',strtotime($date)));
	}

	function transformDATE2() {
		return $this->Day1."/".$this->Month1."/".$this->Year1;
	}
	
	function get2DATES() {
		return $this->Day1.".".$this->Month1.".".$this->Year1."-".$this->Day2.".".$this->Month2.".".$this->Year2;
	}
	
	function weekDATE() {
		$w = date('w',mktime(0, 0, 0, $this->Month1 , $this->Day1 , $this->Year1));
		$m = date('m',mktime(0, 0, 0, $this->Month1 , $this->Day1 , $this->Year1));
		$d = date('d',mktime(0, 0, 0, $this->Month1 , $this->Day1 , $this->Year1));
		$Y = date('Y',mktime(0, 0, 0, $this->Month1 , $this->Day1 , $this->Year1));
		
		$nbr = (0 - $w);
		
		$sunday = date ("Y-m-d",mktime(0, 0, 0, $m , $d + $nbr, $Y));
		$week['sunday'] = $sunday; 
		$week['sundayclass'] = ($w == '0') ? "today" : "";
		$nbr++;
		
		$monday = date ("Y-m-d",mktime(0, 0, 0, $m , $d + $nbr, $Y));
		$week['monday'] = $monday; 
		$week['mondayclass'] = ($w == '1') ? "today" : "";
		$nbr++;
		
		$tuesday = date ("Y-m-d",mktime(0, 0, 0, $m , $d + $nbr, $Y));
		$week['tuesday'] = $tuesday;
		$week['tuesdayclass'] = ($w == '2') ? "today" : "";
		$nbr++;
	
		$wednesday = date ("Y-m-d",mktime(0, 0, 0, $m , $d + $nbr, $Y));
		$week['wednesday'] = $wednesday;
		$week['wednesdayclass'] = ($w == '3') ? "today" : "";
		$nbr++;
	
		$thursday = date ("Y-m-d",mktime(0, 0, 0, $m , $d + $nbr, $Y));
		$week['thursday'] = $thursday;
		$week['thursdayclass'] = ($w == '4') ? "today" : "";
		$nbr++;
	
		$friday = date ("Y-m-d",mktime(0, 0, 0, $m , $d + $nbr, $Y));
		$week['friday'] = $friday;
		$week['fridayclass'] = ($w == '5') ? "today" : "";
		$nbr++;
	
		$saturday = date ("Y-m-d",mktime(0, 0, 0, $m , $d + $nbr, $Y));
		$week['saturday'] = $saturday;
		$week['saturdayclass'] = ($w == '6') ? "today" : "";
		
		return $week;
	}
	
	  	
	//Constructeur de 
  	function getAge()	{
	
		$age = $this->Year2 - $this->Year1;
		
		if ($this->Month2<$this->Month1) {
			$age --;
		} else {
			if ($this->Month2==$this->Month1 && $this->Day2<$this->Day1) {
				$age --;
			}
		}
		
 		return $age;
	}
	
	function distributDATE($granularity) {
		
		$daystart = mktime(0, 0, 0, $this->Month1 , $this->Day1 , $this->Year1);
		$dayend = mktime(0, 0, 0, $this->Month2 , $this->Day2 , $this->Year2);
		$intervale = array();
		
		for($i = 0 ; $i <= $granularity ; $i++) 	{
			$intervale[$i] = $daystart + ((($dayend-$daystart)/$granularity)*$i);
		}
		
		return $intervale;
		
	}
	
	function compare($compare) {
		
		$daystart = mktime(0, 0, 0, $this->Month1 , $this->Day1 , $this->Year1);
		$dayend = mktime(0, 0, 0, $this->Month2 , $this->Day2 , $this->Year2);
		
		$intervale = array();
		
		$intervale[0] = $daystart + (($dayend-$daystart)*$compare);
		$intervale[1] = $dayend + (($dayend-$daystart)*$compare);
		
		return $intervale;
		
	}
	
}

// Se connecte � la DB
function connexion_DB($name_DB) {
	$host = "localhost";  
	$user = "poly";
	$bdd = $name_DB;
	$passwd  = "halifax";
	mysql_connect($host, $user,$passwd) or die("erreur de connexion au serveur");
	mysql_select_db($bdd) or die("erreur de connexion a la base de donnees");
}

// --------------------------------------------------------------------------------------------------------------------------
// Deconnection de la DB
function deconnexion_DB() {
	mysql_close();
}

function convertIntoEntity($var) {
	$specificCaractere = array("�", "�", "�");
	$htmlEntity = array("&eacute;", "&eagrave;", "&agrave;");
	$var = str_replace($specificCaractere, $htmlEntity, $var);
	return $var;
}

function requete_SQL($strSQL) {
	$result = mysql_query($strSQL);
	if (!$result) {
		$message  = 'Erreur SQL : ' . mysql_error() . "<br>\n";
		$message .= 'SQL string : ' . $strSQL . "<br>\n";
		$message .= "Merci d'envoyer ce message au webmaster - targoo@gmail.com";
		die($message);
	}
	return $result;
}

function get_MENUBAR_START() {

	echo "<div id='productsandservices' class='yuimenubar yuimenubarnav' style='display: none'>";
	echo "		<div class='bd'>";
	echo "			<ul class='first-of-type'>";
	echo "				<li class='yuimenubaritem first-of-type'><a href='../../login/index.php'>Logout</a></li>";
	echo "				<li class='yuimenubaritem'><a href='../menu/menu.php'>Menu</a></li>";
	echo "				<li class='yuimenubaritem'>Navigation";
	echo "					<div id='communication' class='yuimenu'>";
	echo "					<div class='bd'>";
	echo "						<ul>";
	echo "							<li class='yuimenuitem'>Agendas";
	echo "		                        <div id='agenda' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../agendas/day.php'>Agenda journalier</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../agendas/week.php'>Agenda hebdomadaire</a></li>";
	echo "                                      	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../agendas/planning.php'>Gestion des horaires hebdomadaires</a></li>";
	echo "                                  	</ul>";
	echo "                              	</div>";
	echo "                          	</div>  ";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Tarifications";
	echo "		                        <div id='tarification' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../tarifications/add_tarification.php'>Ajout d'une nouvelle tarification</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../tarifications/modif_tarification.php'>Reprise de la derni�re tarification</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../tarifications/recherche_tarification.php'>Recherche d'une tarification</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../tarifications/listing_tarification.php'>Listing des tarifications en cours</a></li>";
	//echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../tarifications/correction_tarification.php'>Correction des tarifications erron�es</a></li>";
	//echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../tarifications/add_anomalie.php'>Ajout d'une anomalie pour une prestation</a></li>";
	//echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../tarifications/listing_anomalie.php'>Listing des anomalies en cours</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>  ";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Proth&egrave;ses";
	echo "		                        <div id='prothese' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../protheses/add_prothese.php'>Ajout d'une nouvelle tarification de proth&egrave;se</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../protheses/modif_prothese.php'>Reprise de la derni�re tarification de proth&egrave;se</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../protheses/recherche_prothese.php'>Recherche d'une tarification de proth&egrave;se</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../protheses/listing_prothese.php'>Listing des tarifications de proth&egrave;se en cours</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>  ";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Patients";
	echo "		                        <div id='patient' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../patients/recherche_patient.php'>Recherche et modification d'un patient</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../patients/add_patient_titulaire.php'>Ajout d'une patient titulaire</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../patients/add_patient_non_titulaire.php'>Ajout d'une patient non titulaire</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../patients/listing_patient.php'>Listing des patients</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>  ";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>M&eacute;decins";
	echo "		                        <div id='medecin' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../medecins/recherche_medecin.php'>Recherche et modification des m&eacute;decins</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../medecins/add_medecin.php'>Ajout d'un m&eacute;decin</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../medecins/listing_medecin.php'>Listing des m&eacute;decins</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>  ";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Prestations";
	echo "		                        <div id='prestation' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../cecodis/add_cecodi.php'>Ajout d'une prestation INAMI</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../cecodis/recherche_cecodi.php'>Recherche et modification d'une prestation INAMI</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../cecodis/listing_cecodi.php'>Listing des prestations INAMI</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../actes/add_acte.php'>Ajout d'une prestation interne</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../actes/recherche_acte.php'>Recherche et modification d'une prestation interne</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../actes/listing_acte.php'>Listing des prestations internes</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div> ";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Mutuelles";
	echo "		                        <div id='mutuelle' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../mutuelles/recherche_mutuelle.php'>Recherche et modification d'une mutuelle</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../mutuelles/add_mutuelle.php'>Ajout d'une mutuelle</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../mutuelles/listing_mutuelle.php'>Listing des mutelles</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Listings";
	echo "		                        <div id='listings' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../listings/listing_mutuelles.php'>Facturation aux mutuelles</a></li>";
	//echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../listings/listing_medecins.php'>Facturation aux m&eacute;decins</a></li>";
	//echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../listings/listing_journal_caisse.php'>Journal de caisse</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>";
	echo "                          </li>";
	//echo "							<li class='yuimenuitem'>M&eacute;decine pr&eacute;ventive";
	//echo "		                        <div id='medecine_preventive' class='yuimenu'>";
	//echo "                             		<div class='bd'>";
	//echo "                                    	<ul class='first-of-type'>";
	//echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../medecine_preventive/consulter_pile.php'>Consulter la pile</a></li>";
	//echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../medecine_preventive/creer_motif.php'>Cr&eacute;er de nouveaux motifs</a></li>";
	//echo "                                        </ul>";
	//echo "                                     </div>";
	//echo "                                </div>";
	//echo "                          </li>";
	echo "							<li class='yuimenuitem'>Statistiques";
	echo "		                        <div id='statistiques' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../statistiques/pie_statistique.php'>Statistiques en camenbert</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../statistiques/bar_statistique.php'>Statistiques en batons</a></li>";
	//echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../statistiques/line_statistique.php'>Statistiques en courbes</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Caisses";
	echo "		                        <div id='caisse' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../caisses/modif_caisse.php'>D&eacute;tail de la caisse</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>";
	echo "                          </li>";
	
	echo "							<li class='yuimenuitem'>Erreurs";
	echo "		                        <div id='erreurs' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../erreurs/erreur_patient.php'>Listing des erreurs des patients</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../erreurs/erreur_medecin.php'>Listing des erreurs des m&eacute;decins</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../erreurs/erreur_caisse.php'>Listing des erreurs de caisse</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../erreurs/erreur_poly.php'>Listing des cadeaux</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../erreurs/erreur_commune.php'>Listing des pertes T.M.</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Anomalies";
	echo "		                        <div id='anomalies' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../anomalies/add_anomalie.php'>Ajout d'une anomalie</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../anomalies/recherche_anomalie.php'>Recherche d'une anomalie</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../anomalies/listing_anomalie.php'>Listing des anomalie</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Caisses";
	echo "		                        <div id='caisse' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../caisses/modif_caisse.php'>D&eacute;tail de la caisse</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>";
	echo "                          </li>";
	echo "							<li class='yuimenuitem'>Configs";
	echo "		                        <div id='configuration' class='yuimenu'>";
	echo "                             		<div class='bd'>";
	echo "                                    	<ul class='first-of-type'>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../configurations/code_tarification_gestion.php'>Gestion des codes de tarification</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../configurations/user_gestion.php'>Gestion des utilisateurs</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../configurations/aide_gestion.php'>Gestion des aides en ligne</a></li>";
	echo "                                        	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../configurations/notice_gestion.php'>Gestion des notices</a></li>";
	echo "                                        </ul>";
	echo "                                     </div>";
	echo "                                </div>";
	echo "                            </li>";
	echo "                        </ul>";
	echo "                     </div>";
	echo "                	</div>";  
	echo "             	</li>";
	
}

function get_MENUBAR_END() {

	connexion_DB('poly');
	$result = requete_SQL ("SELECT id, titre, textarea FROM notices");
	$n = mysql_num_rows($result);
	if ($n != 0) {
		echo "              <li class='yuimenubaritem'>Notices";
		echo "              	<div id='notice' class='yuimenu'>";
		echo "                		<div class='bd'>";             
		echo "                      	<ul>";
		while($data = mysql_fetch_assoc($result)) 	{
			echo "                        	<li class='yuimenuitem'>";
			echo "								<a onclick='openNotice(".$data['id'].");' title='' >".$data['titre']."</a>";
			echo "							</li>";
		}
		echo "                        	</ul>";
		echo "                		</div>";
		echo "              	</div>";
		echo "              </li>";
	}
	deconnexion_DB();
	
	echo "              <li class='yuimenubaritem'>Aides";
	echo "              	<div id='help' class='yuimenu'>";
	echo "                		<div class='bd'>";             
	echo "                      	<ul>";
	echo "                            	<li class='yuimenuitem'>";
	echo "									<a onclick='openHelp()' title='Aide sur la page en cours' >Aide</a>";
	echo "								</li>";
	echo "                            	<li class='yuimenuitem'>Version 2.1</a></li>";
	echo "                        	</ul>                    ";
	echo "                		</div>";
	echo "              	</div>";
	echo "              </li>";
	echo "           	</ul>";
	echo "              <div class='date'>";
	echo $_SESSION['nom']." ".$_SESSION['prenom']." - ".$_SESSION['role']." - Application Polyclinique - ".date("d/m/Y");
	echo "             	</div>";
	echo "    		</div>";
	echo "    </div>";
	
}

function get_MENUBAR_PATIENT(){

	echo "<li class='yuimenuitem'>Patients";
	echo "	<div id='patient2' class='yuimenu'>";
	echo "		<div class='bd'>";
	echo "			<ul class='first-of-type'>";
	echo "				<li class='yuimenuitem' id='patientmenu'><a class='yuimenuitemlabel' href='../patients/recherche_patient.php'>Recherche et modification du patient&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>";
	echo "				<li class='yuimenuitem' id='titulairemenu'><a class='yuimenuitemlabel' href='../patients/recherche_patient.php'>Recherche et modification du titulaire&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>";
	echo "			</ul>";
	echo "		</div>";
	echo "	</div>  ";
	echo "</li>";

}

function get_MENU($current) {

	$menu = array('agendas' => '', 'tarifications' => '', 'protheses' => '', 'patients' => '', 'prestations' => '', 'listings' => '', 'caisses' => '' );
	$menu[$current]='current';
	echo "<li class='nodelete ".$menu['agendas']."'>";
	echo "<a class='nodelete' href='../agendas/day.php'>Agendas</a>";
	echo "</li>";
	echo "<li class='nodelete ".$menu['tarifications']."'>";
	echo "<a class='nodelete' href='../tarifications/add_tarification.php'>Tarifications</a>";
	echo "</li>";
	echo "<li class='nodelete ".$menu['protheses']."'>";
	echo "<a class='nodelete' href='../protheses/add_prothese.php'>Proth&egrave;ses</a>";
	echo "</li>";
	echo "<li class='nodelete ".$menu['patients']."'>";
	echo "<a class='nodelete' href='../patients/recherche_patient.php'>Patients</a>";
	echo "</li>";
	echo "<li class='nodelete ".$menu['prestations']."'>";
	echo "<a class='nodelete' href='../cecodis/recherche_cecodi.php'>Prestations</a>";
	echo "</li>";
	echo "<li class='nodelete ".$menu['listings']."'>";
	echo "<a class='nodelete' href='../listings/listing_mutuelles.php'>Listings</a>";
	echo "</li>";
	echo "<li class='nodelete ".$menu['caisses']."'>";
	echo "<a class='nodelete' href='../caisses/modif_caisse.php'>Caisses</a>";
	echo "</li>";
	echo "</li>";
	//echo "<li class='nodelete ".$menu['medecine_preventive']."'>";
	//echo "<a class='nodelete' href='../medecine_preventive/consulter_pile.php'>Pr&eacute;vention</a>";
	//echo "</li>";
	
}

function get_DAY($date) {

	$tok = strtok($date,"-");
	$year = $tok;
	$tok = strtok("-");
	$month = $tok;
	$tok = strtok("-");
	$day = $tok;
	
	return date('w',mktime(0, 0, 0, $month , $day , $year));

}


?>
