<section class="homme-banner-section">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <?php if(isset($user)): ?>
                    <?php if($user['idRole']==1): ?>  <!-- Daca utilizatorul are rolul de freelancer -->
                    <div class="col-xs-12 col-md-7 text-center">
                        <h2>Trei pasi simpli pentru a-ti gasi un job pe placul tau</h2>
                        <div class="rows">
                            <div class="col-xs-12 col-sm-4">
                                <div class="step-icon">
                                    <img src="images/step-1.png">
                                </div>
                                <div class="step-text">
                                    <p>1) Alegi un proiect si lasi un raspuns</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="step-icon">
                                    <img src="images/step-2.png">
                                </div>
                                <div class="step-text">
                                    <p>2) Angajatorul accepta serviciile tale</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="step-icon">
                                    <img src="images/step-3.png">
                                </div>
                                <div class="step-text">
                                    <p>3) Proiectul este finisat si recompensa primita</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-5 text-center">
                        <h1>Sute de angajatori sunt in cautarea specilistilor calificati</h1>
                        <h4>Ofera serviciile tale si primeste recompensa bine meritata</h4>
                        <a href="index.php?c=projects" class="btn btn-success">Cauta un job</a>
                    </div>

                    <?php elseif($user['idRole']==2): ?>  <!-- Daca utilizatorul are rolul de angajator -->

                    <div class="col-xs-12 col-md-7 text-center">
                        <h2>Trei pasi simpli pentru efectuarea unei sarcini</h2>
                        <div class="rows">
                            <div class="col-xs-12 col-sm-4">
                                <div class="step-icon">
                                    <img src="images/step-1.png">
                                </div>
                                <div class="step-text">
                                    <p>1) Ne spui de ce ai nevoie</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="step-icon">
                                    <img src="images/step-2.png">
                                </div>
                                <div class="step-text">
                                    <p>2) Noi trimitem sarcina unui expert</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="step-icon">
                                    <img src="images/step-3.png">
                                </div>
                                <div class="step-text">
                                    <p>3) Sarcina este executata cu succes!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-5 text-center">
                        <h1>Sute de specilisti calificati sunt disponibili pentru tine</h1>
                        <h4>Creaza un proiect chiar acum si asteapta rezultate</h4>
                        <a href="index.php?c=newProject" class="btn btn-success">Publica un proiect</a>
                    </div>
                    <?php endif ?>

                <?php else: ?> <!-- Daca utilizatorul nu este logat-->
                <div class="col-xs-12 col-md-7 text-center">
                    <h2>Trei pasi simpli pentru efectuarea unei sarcini</h2>
                    <div class="rows">
                        <div class="col-xs-12 col-sm-4">
                            <div class="step-icon">
                                <img src="images/step-1.png">
                            </div>
                            <div class="step-text">
                                <p>1) Ne spui de ce ai nevoie</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="step-icon">
                                <img src="images/step-2.png">
                            </div>
                            <div class="step-text">
                                <p>2) Noi trimitem sarcina unui expert</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="step-icon">
                                <img src="images/step-3.png">
                            </div>
                            <div class="step-text">
                                <p>3) Sarcina este executata cu succes!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-5 text-center">
                    <h1>Transforma-ti ideele in realitate cu Beefreelancer</h1>
                    <h4>Alatura-te si foloseste pe deplin serviciile noastre chiar acum</h4>
                    <a href="index.php?c=reg" class="btn btn-success">Inregistreaza-te</a>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
<section class="offers-section">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <h3>Pentru cei care au nevoie de un specialist (freelancer).</h3>
                    <p>Aici puteti găsi cei mai buni profesioniști independenți (freelanceri) din Republica Moldova. Programatori, experți în testare,SEO specialiști, designeri, copywriteri, fotografi, trăducători - mii de muncitori de la distanță de orice specializare liber profesionistă.</p>
                    <p>E suficient doar să publicați un proiect și persoanele interesate vă vor oferi serviciile ajutîndu-vă să creați o sarcină, să identificați bugetul și termenul limită de execuție a proiectului. Dvs vă rămîne să alegeți din numărul de freelanceri care au răspuns la proiect și să începeți o colaborare.</p>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <h3>Cei care sunt în căutarea de muncă la domiciliu (pentru freelanceri).</h3>
                    <p>Pentru dvs in fiecare zi avem zeci de proiecte pe diferite specializări. Dacă căutați unui job independent și sunteți un bun specialist într-un anumit domeniu, puteți furniza servicii de freelancing folosind platforma nostră.</p>
                    <p>Înainte de a începe lucrul pe site-ul nostru, trebuie mai întîi să completați portofoliul de freelancer, adăugînd exemple de proiecte și comenzi executate cu succes. Adăugați în profilul personal toate informația necesară cu privire la abilitățile și experiența dvs și adăugați detalii de contact.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="services-section">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-xs-12"><h3 class="text-center">Catalog de freelanceri</h3></div>
                <?php foreach($categories as $category): ?>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="service-box">
                        <img src="<?=$category['categoryImage']?>" class="img-responsive" alt="<?=$category['name']?>">
                        <div class="service-box-caption">
                            <div class="service-box-caption-content">
                                <div class="service-name">
                                    <?=$category['name']?>
                                </div>
                                <div class="service-projects">
                                    <?=$category['users']?> freelanceri
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<section class="best-freelancers-section">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-xs-12"><h3 class="text-center">Cei mai buni freelanceri</h3></div>
                <?php foreach ($bestFreelancers as $bestFreelancer):?>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <table>
                            <tr>
                                <td align="left" valign="top">
                                    <img class="img-rounded" src="<?=$bestFreelancer['profileImage']?>" width="100">
                                </td>
                                <td align="left" valign="top">
                                    <p class="name"><a href="index.php?c=profile&idUser=<?=$bestFreelancer['idUser']?>"><?=$bestFreelancer['lastName']?> <?=$bestFreelancer['firstName']?></a></p>
                                    <p class="specialty"><a href="index.php?specialization&idSpecialization=<?=$bestFreelancer['idSpecialization']?>"><?=$bestFreelancer['specialization']?></a></p>
                                    <p><?=$bestFreelancer['status']?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<section class="statistics-section">
    <div class="container-fluid">
        <div class="container text-center">
            <div class="row">
                <div class="col-xs-6">
                    <h2><?=$numberOfUsers?></h2>
                    <p>Utilizatori inregistrati</p>
                </div>
                <div class="col-xs-6">
                    <h2><?=$numberOfProjects?></h2>
                    <p>Proiecte publicate</p>
                </div>
            </div>
        </div>
    </div>
</section>