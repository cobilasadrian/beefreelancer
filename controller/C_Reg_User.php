<?php
include_once('controller/C_Base.php');

//
//Controller-ul paginii de inregistrare.
//
class C_Reg_User extends C_Base
{

    //
    // Procesorul virtual de cerere
    //
    protected function OnInput()
    {
        parent::OnInput();
        $this->title = $this->title . ' - Inregistrare';

        //Menagerul utilizatorilor
        $mUsers = M_Users::Instance();

        if ($this->IsPost()) {
            if (isset($_POST['regBtn']))
            {
                //Verificam și pregatim datele pentru setare in BD
                if ($this->issetAndNotEmpty(trim($_POST['email'])) and $this->issetAndNotEmpty(trim($_POST['password'])) and
                    $this->issetAndNotEmpty(trim($_POST['role'])) and $this->issetAndNotEmpty(trim($_POST['lastName'])) and
                    $this->issetAndNotEmpty(trim($_POST['firstName'])) and $this->issetAndNotEmpty(trim($_POST['sex'])) and
                    $this->issetAndNotEmpty(trim($_POST['year'])) and $this->issetAndNotEmpty(trim($_POST['month'])) and
                    $this->issetAndNotEmpty(trim($_POST['day'])))
                {
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);
                    $role = trim($_POST['role']);
                    $idRole = 1;
                    if($role == 'employer')
                        $idRole = 2;
                    $lastName = trim($_POST['lastName']);
                    $firstName = trim($_POST['firstName']);
                    $sex = trim($_POST['sex']);
                    $year = trim($_POST['year']);
                    $month = trim($_POST['month']);
                    $day = trim($_POST['day']);
                    $address = trim($_POST['address']);
                    $phoneNumber = trim($_POST['phoneNumber']);
                    $skypeAccount = trim($_POST['skypeAccount']);

                    if(empty($mUsers->getUserByEmail($email)))
                    {
                        $uploadFile = null;
                        $source = null;
                        if(!empty($_FILES['profileImage']['name']))
                        {
                            if(preg_match('/[.](JPEG)|(jpeg)|(jpg)|(JPG)|(gif)|(GIF)|(png)|(PNG)$/',
                                $_FILES['profileImage']['name']))
                            {
                                if(filesize($_FILES['profileImage']['tmp_name']) > 2048)
                                {
                                    $uploadFile = $_FILES['profileImage']['name'];
                                    $source = $_FILES['profileImage']['tmp_name'];
                                }
                                else {
                                    exit ("Eroare. Marimea imaginii de profil nu trebuie sa depaseasca 2048 KB. <br/>");
                                }
                            }
                            else {
                                exit ("Eroare. Formatul imaginii de profil trebuie sa fie JPG, PNG sau GIF. <br/>");
                            }
                        }

                        if ($mUsers->regUser($email,$password,$uploadFile,$source,$idRole,$lastName,$firstName,
                                                $sex,$year,$month,$day,$address,$phoneNumber,$skypeAccount))
                        {
                            if ($mUsers->login($email,$password,false))
                            {
                                header('Location: index.php');
                                die();
                            }
                        }
                    }
                    else {
                        exit ("Eroare. Utilizator cu astfel de email deja exista. <br/>");
                    }
                }
                else {
                    exit ("Eroare. Nu ati completat toate cimpurile obligatorii.  <br/>");
                }
            }
        }

    }

    //
    // Generatorul virtual de HTML.
    //
    protected function OnOutput()
    {
        $vars = array('title' => $this->title);
        $this->content = $this->Template('view/tpl_reg_user.php', $vars);
        parent::OnOutput();
    }
}
