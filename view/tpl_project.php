<section class="project-section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3><?=$project['title']?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <table>
                    <tr>
                        <td align="left" valign="top">
                            <a href="index.php?c=profile&idUser=<?=$project['idAuthor']?>">
                                <img src="<?=$project['authorProfileImage']?>" width="64" alt="<?=$project['authorLastName']?> <?=$project['authorFirstName']?>" class="img-rounded authorProfileImage">
                            </a>
                        </td>
                        <td align="left" valign="top">
                            <p class="authorName">
                                <a href="index.php?c=profile&idUser=<?=$project['idAuthor']?>">
                                    <?=$project['authorLastName']?> <?=$project['authorFirstName']?>
                                </a>
                            </p>
                            <p><strong><small><?php if ($isAuthorOnline) echo "Este acum"; else echo "Nu este"; ?> online</small><strong></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-4 text-right">
                <strong>Bugetul:</strong>   <?php if(empty($project['budget'])): ?> nu este indicat <?php else:?>
                <?=$project['budget']?> <?=$project['budgetCurrency']?>
                <?php endif ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p><?=$project['description']?></p>
            <div
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-4">
                <p><strong>Specializarea:</strong>
                    <a href="index.php?c=specialization&idSpecialization=<?=$project['idSpecialization']?>">
                        <?=$project['specialization']?>
                    </a>
                </p>
            </div>
            <div class="col-xs-6 col-sm-4">
                <p><strong>Postat:</strong> <?=$project['publishDate']?></p>
            </div>
            <div class="col-xs-6 col-sm-4">
                <p><strong>Vizualizari:</strong> <?=$project['views']?> </p>
            </div>
        </div>
        <?php if(!empty($user) and $user['idRole'] == 1 and !$isAnswer): ?>
        <div class="row">
            <div class="col-xs-12">
                <h3>Lasa un raspuns</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <form method="post" class="form-horizontal">
                    <input type="hidden" name="author" value="<?=$user['idUser']?>">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>Buget</label>
                        </div>
                        <div class="col-xs-8 col-sm-4">
                            <input type="number" name="budget" class="form-control">
                        </div>
                        <div class="col-xs-4 col-sm-2">
                            <select class="form-control" name="budgetCurrency">
                                <option value="MDL">MDL</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="RON">RON</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>Termen de executie</label>
                        </div>
                        <div class="col-xs-8 col-sm-4">
                            <input type="number" name="executionTime" class="form-control">
                        </div>
                        <div class="col-xs-4 col-sm-2">
                            <select class="form-control" name="timeUnit">
                                <option value="Ore">Ore</option>
                                <option value="Zile">Zile</option>
                                <option value="Saptamini">Saptamini</option>
                                <option value="Ani">Ani</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>Raspunsul *</label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                        <textarea name="answer" class="form-control" rows="4">
                        </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                            <p class="help-block">Cimpurile marcate cu (*) sunt obligatorii pentru completare</p>
                            <button type="submit" name="addAnswerBtn" class="btn btn-success">Trimite</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php endif ?>
        <div class="row">
            <div class="col-xs-12">
                <h3>Raspunsuri la proiect (<?=$numberOfAnswers?>)</h3>
            </div>
        </div>
        <?php foreach($answers as $answer):?>
        <div class="row">
            <div class="<?php if(!empty($user) and $user['idUser'] == $project['idAuthor'] and !$project['executor']): ?>col-xs-6<?php else: ?>col-xs-12<?php endif ?>">
                <table>
                    <tr>
                        <td align="left" valign="top">
                            <a href="index.php?c=profile&idUser=<?=$answer['idAuthor']?>">
                                <img src="<?=$answer['authorProfileImage']?>" width="64" alt="<?=$answer['authorLastName']?> <?=$answer['authorFirstName']?>" class="img-rounded authorProfileImage">
                            </a>
                        </td>
                        <td align="left" valign="top">
                            <p class="authorName">
                                <a href="index.php?c=profile&idUser=<?=$answer['idAuthor']?>">
                                    <?=$answer['authorLastName']?> <?=$answer['authorFirstName']?>
                                </a>
                            </p>
                            <?php if($project['executor'] and $answer['idAuthor'] == $project['executor']): ?>
                            <p style="color:#ac2925;"><strong><small>Executantul proiectului</strong></p>
                            <?php endif ?>
                        </td>
                    </tr>
                </table>
            </div>
            <?php if(!empty($user) and $user['idUser'] == $project['idAuthor'] and !$project['executor']): ?>
            <div class="col-xs-6 text-right">
                <form method="post">
                    <div class="form-group">
                        <input type="hidden" name="executor" value="<?=$answer['idAuthor']?>">
                        <button type="submit" name="setExecutorBtn" class="btn btn-success">Stabileste ca executant</button>
                    </div>
                </form>
            </div>
            <?php endif ?>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p><strong>Adaugat:</strong> <?=$answer['publishDate']?></p>
                <p>
                    <?=$answer['answer']?>
                </p>
                <p><strong>Portofoliu:</strong></p>
                <ul>
                    <li>
                        <a href="index.php?c=profile&idUser=<?=$answer['idAuthor']?>">
                            index.php?c=profile&idUser=<?=$answer['idAuthor']?>
                        </a>
                    </li>
                </ul>
                <div class="answer-details">
                    <p><strong>Bugetul propus:</strong>
                        <?php if(empty($answer['budget'])): ?> nu este indicat <?php else:?>
                        <?=$answer['budget']?> <?=$answer['budgetCurrency']?>
                        <?php endif ?>
                    </p>
                    <p><strong>Termen de executie:</strong>
                        <?php if(empty($answer['executionTime'])): ?> nu este indicat <?php else:?>
                        <?=$answer['executionTime']?> <?=$answer['timeUnit']?></p>
                        <?php endif ?>
                </div>
            </div>
        </div>
        <?php endforeach ?>
        <?php if(!empty($user) and $user['idRole'] == 2 and $project['idAuthor'] != $user['idUser']): ?>
        <div class="row">
            <div class="col-xs-12">
                <a href="index.php?c=newProject" class="btn btn-success">Publica un proiect</a>
            </div>
        </div>
        <?php endif ?>
    </div>
</section>
