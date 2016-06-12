<?php
include_once('model/DB.php');

/**
 *  Managerul utilizatorilor
 */
class M_Users
{	
	private static $instance;	// instanta clasei
	private $sessionId;			// identificatorul sesiunii curente
	private $userId;			// identificatorul utilizatorului curent
	private $onlineMap;			// harta utilizatorilor online
	private $profileImagesDir;  // directiva imaginelor de profil
	private $worksImagesDir; 	// directiva imaginelor lucrarilor din portofoliu

	/**
	 * Primim instanta clasei
	 * @return M_Users
     */
	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new M_Users();
			
		return self::$instance;
	}

	/**
	 * M_Users constructor.
     */
	public function __construct()
	{
		$this->sessionId = null;
		$this->userId = null;
		$this->onlineMap = null;
		$this->profileImagesDir = 'usersImages/profileImages/';
		$this->worksImagesDir = 'usersImages/worksImages/';
	}

	/**
	 * Stergerea sesiunelor neutilizate
     */
	public function clearSessions(){
		$conn = DB::getInstance();
		$conn->exec("DELETE FROM sessions WHERE timeLast < NOW() - INTERVAL 10 MINUTE");
	}

	/**
	 * Delogare
     */
	public function logout()
	{
		setcookie('email', '', time() - 1);
		setcookie('password', '', time() - 1);
		unset($_COOKIE['email']);
		unset($_COOKIE['password']);
		unset($_SESSION['sessionId']);
		$this->sessionId = null;
		$this->userId = null;
	}

	/**
	 * Logarea utilizatorului
	 * @param $email - adresa de email a utilizatorului
	 * @param $password - - parola
	 * @param bool $remember - trebue de memorat in cookie
	 * @return bool - rezultatul true sau false
     */
	public function login($email, $password, $remember=true)
	{
		// primim utilizatorul din BD 
		$user = $this->getUserByEmail($email);

		if ($user == null)
			return false;

		// verificam parola
		if ($user['password'] != md5($password))
			return false;
				
		// memoram email-ul si md5(parola) in cookies
		if ($remember)
		{
			$expire = time() + 3600 * 24 * 100;
			setcookie('email', $email, $expire);
			setcookie('password', md5($password), $expire);
		}		
				
		// deschidem sesiunea si memoram SID
		$this->sessionId = $this->createSession($user['idUser']);

		return true;
	}

	/**
	 * Primim numarul total de utilizatori inregistrati
	 * @return number of users
     */
	public function getNumberOfUsers(){
		$conn = DB::getInstance();
		$result = $conn->query("SELECT count(*) FROM users")->fetch(PDO::FETCH_NUM);
		return $result[0];
	}

	/**
	 * Primim utilizatorul dupa Email
	 * @param $email - adresa de email a utilizatorului
	 * @return array - obiect utilizator
     */
	public function getUserByEmail($email){
		$conn = DB::getInstance();
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
		$stmt->execute(array(':email' => $email));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (!isset($result[0]))
			return null;
		return $result[0];
	}

	/**
	 * Primim utilizatorul dupa ID
	 * @param $idUser - daca nu-i indicat ID-ul, il luam pe cel curent
	 * @return array - obiect utilizator
     */
	public function getUserById($idUser = null)
	{	
		// Daca ID-ul utilizatorului nu-i indicat, il luam din sesiunea curenta.
		if ($idUser == null)
			$idUser = $this->getUserId();
			
		if ($idUser == null)
			return null;

		$conn = DB::getInstance();
		$stmt = $conn->prepare("SELECT * FROM users WHERE idUser=:idUser");
		$stmt->execute(array(':idUser' => $idUser));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $result[0];
	}

	/**
	 * Primim ID-ul utilizatorului curent
	 * @return int - ID-ul utilizatorului
     */
	public function getUserId()
	{	
		// Verificare cache.
		if ($this->userId != null)
			return $this->userId;

		// Primim din sesiunea curenta.
		$sid = $this->getSessionId();
				
		if ($sid == null)
			return null;

		$conn = DB::getInstance();
		$stmt = $conn->prepare("SELECT idUser FROM sessions WHERE sid=:sid");
		$stmt->execute(array(':sid' => $sid));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Daca sesiunea n-a fost gasita inseamna ca utilizatorul nu a fost gasit.
		if (count($result) == 0)
			return null;
			
		// Daca am gasit-o atunci o memoram.
		$this->userId = $result[0]['idUser'];
		return $this->userId;
	}

	/**
	 * Crearea unei sesiuni noi
	 * @param $idUser - Identificatorul utilizatorului
	 * @return string - SID
     */
	private function createSession($idUser)
	{
		// generam SID
		$sid = $this->generateStr(10);

		// introducem SID in BD
		$conn = DB::getInstance();
		$stmt = $conn->prepare("INSERT INTO sessions(idUser, sid, timeStart, timeLast) VALUES(:idUser,:sid,NOW(),NOW())");
		$stmt->execute(array(':idUser' => $idUser, ':sid' => $sid));
		if($stmt->rowCount()>0){
			$_SESSION['sessionId'] = $sid;
		}
		// returnam SID
		return $sid;
	}

	/**
	 * Generarea unei secvente aleatoare
	 * @param int $length - lungimea
	 * @return string - sir aleator
	 */
	private function generateStr($length = 10)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length)
			$code .= $chars[mt_rand(0, $clen)];

		return $code;
	}

	/**
	 * Identificatorul sesiunei curente
	 * @return null|string - SID
     */
	private function getSessionId()
	{
		// Verificare cache.
		if ($this->sessionId != null)
			return $this->sessionId;

		$sid = null;
		// Cautam SID in sesiune.
		if(isset($_SESSION['sessionId'])) {
			$sid = $_SESSION['sessionId'];

			// Daca am gasit incercam sa reinoim timeLast in BD.
			$conn = DB::getInstance();
			$stmt = $conn->prepare("UPDATE sessions SET timeLast=NOW() WHERE sid=:sid");
			$stmt->execute(array(':sid' => $sid));
			$affected_rows = $stmt->rowCount();

			if ($affected_rows == 0) {
				$stmt = $conn->prepare("SELECT count(*) FROM sessions WHERE sid=:sid");
				$stmt->execute(array(':sid' => $sid));
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if ($result[0]['count(*)'] == 0)
					$sid = null;
			}
		}

		// Daca nu-i sesiune cautam login-ul si md5(parola) in  cookie.
		if ($sid == null && isset($_COOKIE['email']))
		{
			$user = $this->getUserByEmail($_COOKIE['email']);

			if ($user != null && $user['password'] == $_COOKIE['password'])
				$sid = $this->createSession($user['idUser']);
		}

		// Memoram in cache.
		if ($sid != null)
			$this->sessionId = $sid;

		// Returnam SID.
		return $sid;
	}

	/**
	 * Metoda de inregistrare a utilizatorilor
	 * @param $email
	 * @param $password
	 * @param $uploadFile
	 * @param $source
	 * @param $idRole
	 * @param $lastName
	 * @param $firstName
	 * @param $sex
	 * @param $year
	 * @param $month
	 * @param $day
	 * @param null $address
	 * @param null $phoneNumber
	 * @param null $skypeAccount
     * @return true sau false
     */
	public function regUser($email, $password, $uploadFile, $source, $idRole, $lastName, $firstName, $sex,
							$year, $month, $day, $address = null, $phoneNumber = null, $skypeAccount = null)
	{

		// Pregatirea datelor
		$birthday = $year."-".$month."-".$day;
		$password = md5($password);
		$profileImage = $this->saveProfileImage($uploadFile,$source);

		// introducem in BD
		$conn = DB::getInstance();
		$stmt = $conn->prepare("INSERT INTO users(email,password,profileImage,idRole,firstName,lastName,
												  sex,birthday,address,phoneNumber,skypeAccount,registrationDate)
								VALUES(:email,:password,:profileImage,:idRole,:firstName,:lastName,
										:sex,:birthday,:address,:phoneNumber,:skypeAccount,NOW())");

		$stmt->execute(array(':email' => $email,':password' => $password, ':profileImage' => $profileImage, ':idRole' => $idRole,
							':firstName' => $firstName, ':lastName' =>$lastName, ':sex' => $sex, ':birthday' => $birthday,
							':address' => $address, ':phoneNumber' => $phoneNumber, ':skypeAccount' => $skypeAccount));

		return ($stmt->rowCount()>0);
	}

	/**
	 * Salvam imaginea de profil a utilizatorului
	 * @param $uploadFile
	 * @param $source
	 * @return string - profile image path
     */
	private function saveProfileImage($uploadFile, $source)
	{
		$target = $this->profileImagesDir.$uploadFile;
		move_uploaded_file($source, $target); // se incarca imaginea originala in usersImages/profileImages/

		$image = null;
		if(preg_match('/[.](GIF)|(gif)$/', $uploadFile))
		{
			$image = imagecreatefromgif($this->profileImagesDir.$uploadFile) ; // Daca originalul a fost in format GIF atunci cream o imagine in acelasi format.
		}
		elseif(preg_match('/[.](PNG)|(png)$/', $uploadFile))
		{
			$image = imagecreatefrompng($this->profileImagesDir.$uploadFile) ; // Daca originalul a fost in format PNG atunci cream o imagine in acelasi format.
		}

		elseif(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $uploadFile))
		{
			$image = imagecreatefromjpeg($this->profileImagesDir.$uploadFile); // Daca originalul a fost in format JPEG atunci cream o imagine in acelasi format.
		}
		else { return false; }

		$width_orig = imagesx($image); //Se calculeaza latimea fisierului sursa
		$height_orig = imagesy($image); //Se calculeaza inaltimea fisierului sursa


		// dest - imaginea rezultat 128x128
		// new_width - latimea imaginii
		// new_height - inaltimea

		$new_width = 128;
		$new_height = 128;

		// se creaza o imagine patrata goala
		// este important sa fie truecolor!, altfel vom avea rezultate pe 8 biti
		$dest = imagecreatetruecolor($new_width,$new_height);

		// se taie imaginea dupa x, in cazul in care este orizontala
		if ($width_orig>$height_orig)
			imagecopyresampled($dest, $image, 0, 0,
					round((max($width_orig,$height_orig)-min($width_orig,$height_orig))/2),
					0, $new_width, $new_height, min($width_orig,$height_orig), min($width_orig,$height_orig));

		// se taie imaginea dupa y, in cazul in care este orizontala
		if ($width_orig<$height_orig)
			imagecopyresampled($dest, $image, 0, 0, 0, 0, $new_width, $new_height,
					min($width_orig,$height_orig), min($width_orig,$height_orig));

		// imaginea patrata este redimensionata fara taieri
		if ($width_orig==$height_orig)
			imagecopyresampled($dest, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $width_orig);


		$nameImg = $this->generateStr(10);
		$profileImgPath = $this->profileImagesDir.$nameImg.".jpeg";
		imagejpeg($dest, $profileImgPath);//se pastreaza imaginea in format JPEG

		$delfull = $this->profileImagesDir.$uploadFile;
		unlink ($delfull);// Stergem imaginea originala incarcata, nu mai avem nevoie de ea.

		return $profileImgPath;
	}

	/**
	 * Setam statutul utilizatorilor
	 * @param $status - textul statutului
	 * @param $idUser - ID-ul utilizatorului
	 * @return bool - true sau false
     */
	public function setStatus($status, $idUser){
		if($status=="")
			$status = null;
		$conn = DB::getInstance();
		$stmt = $conn->prepare("UPDATE users SET status = :status WHERE idUser = :idUser");
		$stmt->execute(array(':status' => $status, ':idUser' => $idUser));
		return ($stmt->rowCount()>0);
	}

	/**
	* Verificam privilegiile
	* $privilege - nume privilegiu
	* $idUser - daca nu este specificat, inseamna ca cel curent
	* rezultat - true sau false
	*/
	public function can($privilege, $idUser = null)
	{
		if ($idUser == null)
			$idUser = $this->getUserId();

		$conn = DB::getInstance();
		$stmt = $conn->prepare("SELECT count(*) FROM privileges2roles
								LEFT JOIN users ON users.idRole = privileges2roles.idRole
								LEFT JOIN privileges ON privileges.idPrivilege = privileges2roles.idPrivilege
								WHERE users.idUser = :idUser  AND privileges.name = :privilege");
		$stmt->execute(array(':idUser' => $idUser,':privilege' => $privilege));
		$result = $stmt->fetch(PDO::FETCH_NUM);

		return ($result[0] > 0);
	}

	/**
	 * Primim cei mai buni freelanceri
	 * @return array
	 */
	public function getBestFreelancers(){
		$conn = DB::getInstance();
		$result = $conn->query("SELECT users.idUser, users.profileImage, users.firstName, users.lastName, users.status,
								specializations.idSpecialization, specializations.name AS specialization
								FROM users
								JOIN (specializations2users JOIN specializations
								ON specializations.idSpecialization = specializations2users.idSpecialization )
								ON users.idUser = specializations2users.idUser
								WHERE users.idRole = 1
								GROUP BY users.idUser
								ORDER BY users.idUser ASC")->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * Primim toate categoriile si numarul de freelanceri pentru fiecare
	 * @return array
	 */
	public function getCategories(){
		$conn = DB::getInstance();
		$result = $conn->query("SELECT categories.*, count(specializations2users.idUser) AS users
                        FROM categories
                        LEFT JOIN (specializations JOIN specializations2users
                        ON specializations2users.idSpecialization = specializations.idSpecialization)
                        ON categories.idCategory = specializations.idCategory
                        GROUP BY categories.name
                        ORDER BY categories.idCategory ASC")->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * Verificam daca utilizatorul este online
	 * @param $idUser -Identificatorul utilizatorului
	 * @return bool
     */
	public function isOnline($idUser)
	{
		$conn = DB::getInstance();
		$stmt = $conn->prepare("SELECT idUser FROM sessions WHERE idUser = :idUser");
		$stmt->execute(array(':idUser' => $idUser));
		$result = $stmt->fetch(PDO::FETCH_NUM);
		return ($result[0] > 0);
	}
}