<section class="projects-section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-4 align-right">
                <div class="filter">
                    <h3>Filtreaza proiectele</h3>
                    <form class="form" method="post" accept-charset="UTF-8">
                        <div class="form-group">
                            <label>Specializarea: </label>
                            <select name="specialization" id="specializations" class="form-control">
                                <option value="">Toate specializarile</option>
                                <?php foreach($specializations as $category => $values): ?>
                                    <optgroup label="<?=$category?>">
                                    <?php foreach($values as $specialization): ?>
                                        <option value="<?=$specialization?>" <?php if (isset($searchData['specialization']) and $searchData['specialization'] == $specialization) echo "selected"; ?>><?=$specialization?></option>
                                    <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label>Bugetul minim: </label>
                            </div>
                            <div class="col-xs-6 form-group">
                                <input type="number" name="budget" class="form-control" placeholder="ex. 1000" <?php if (isset($searchData['budget'])): ?> value="<?=$searchData['budget']?>"<?php endif?>>
                            </div>
                            <div class="col-xs-6 form-group">
                                <select class="form-control" name="budgetCurrency">
                                    <option value="MDL" <?php if (isset($searchData['budgetCurrency']) and $searchData['budgetCurrency'] == 'MDL') echo "selected"; ?>>MDL</option>
                                    <option value="USD" <?php if (isset($searchData['budgetCurrency']) and $searchData['budgetCurrency'] == 'USD') echo "selected"; ?>>USD</option>
                                    <option value="EUR" <?php if (isset($searchData['budgetCurrency']) and $searchData['budgetCurrency'] == 'EUR') echo "selected"; ?>>EUR</option>
                                    <option value="RON" <?php if (isset($searchData['budgetCurrency']) and $searchData['budgetCurrency'] == 'RON') echo "selected"; ?>>RON</option>
                                </select>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="withoutExecutor" <?php if (isset($searchData['withoutExecutor'])) echo "checked"; ?>><b>Nu afisa proiectele in care executantul a fost ales</b></label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="lessTwoAnswers" <?php if (isset($searchData['lessTwoAnswers'])) echo "checked"; ?>><b>Mai putin de doua raspunsuri</b></label>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group filter-btn">
                                <button type="submit" name="startFilterBtn" class="btn btn-success btn-block">Filtreaza</button>
                            </div>
                            <div class="col-sm-6 form-group filter-btn">
                                <button type="submit" <?php if (empty($searchData)) echo "disabled";?> name="stopFilterBtn" class="btn btn-link btn-block">Opreste filtru</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xs-12 col-md-8">
                <div class="latest-projects">
                    <h3>Proiecte recent postate <?php if(empty($projects)): ?><small>nu exista</small><?php endif ?> </h3>
                    <?php foreach($projects as $project): ?>
                    <div class="project">
                        <table width="100%">
                            <tr>
                                <td class="title">
                                    <a href="index.php?c=project&idProject=<?=$project['idProject']?>"><h4><?=$project['title']?></h4></a>
                                </td>
                                <td class="budjet" align="right">
                                    <b><?=$project['budget']?> <?=$project['budgetCurrency']?></b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td class="specialty"><a href="index.php?specialization&idSpecialization=<?=$project['idSpecialization']?>"><?=$project['specialization']?></a></td>
                                            <td class="time"><i class="fa fa-clock-o" aria-hidden="true"></i> Postat: <?=$project['publishDate']?></td>
                                            <td class="views"><i class="fa fa-eye" aria-hidden="true"></i> <?=$project['views']?></td>
                                            <td class="responses"><i class="fa fa-comment-o" aria-hidden="true"></i> <?=$project['answers']?> raspunsuri</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php endforeach ?>
                </div>
                <?php
                // Verificam daca sagetile inapoi sunt necesare
                $prevpage = null;
                if ($currentPage != 1) $prevpage =
                    "<li>
                        <a href=\"index.php?c=projects&page=1\">
                            <i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i>
                            <i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i>
                        </a>
                    </li>
                    <li>
                        <a href=\"index.php?c=projects&page=".($currentPage - 1)."\">
                            <i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i>
                        </a>
                    </li>";
                // Verificam daca sagetile inainte sunt necesare
                $nextpage = null;
                if ($currentPage != $pages) $nextpage =
                    "<li>
                        <a href=\"index.php?c=projects&page=".($currentPage + 1)."\">
                            <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i>
                        </a>
                    </li>
                    <li>
                        <a href=\"index.php?c=projects&page=".$pages."\">
                            <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i>
                            <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i>
                        </a>
                    </li>";
                // Gasim doua cele mai apropiate pagini din ambele parti, daca ele exista
                $page2left = null;
                if($currentPage - 2 > 0) $page2left = "<li><a href=\"index.php?c=projects&page=".($currentPage - 2)."\">".($currentPage - 2)."</a></li>";
                $page1left = null;
                if($currentPage - 1 > 0) $page1left = "<li><a href=\"index.php?c=projects&page=".($currentPage - 1)."\">".($currentPage - 1)."</a></li>";
                $page2right = null;
                if($currentPage + 2 <= $pages) $page2right = "<li><a href=\"index.php?c=projects&page=".($currentPage + 2)."\">".($currentPage + 2)."</a></li>";
                $page1right = null;
                if($currentPage + 1 <= $pages) $page1right = "<li><a href=\"index.php?c=projects&page=".($currentPage + 1)."\">".($currentPage + 1)."</a></li>";
                ?>
                <div class="text-center">
                    <nav>
                        <ul class="pagination">
                            <?=$prevpage?>
                            <?=$page2left?>
                            <?=$page1left?>
                            <li class="active">
                                <a href="#">
                                    <?=$currentPage?>
                                </a>
                            </li>
                            <?=$page1right?>
                            <?=$page2right?>
                            <?=$nextpage?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>