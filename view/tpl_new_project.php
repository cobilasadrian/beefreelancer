<section class="new-project-section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3>Creaza un proiect (sarcina)</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <form method="post" class="form-horizontal">
                    <input type="hidden" name="author" value="<?=$user['idUser']?>">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Denumirea proiectului: *</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Descrierea detaliata: *</label>
                        </div>
                        <div class="col-sm-9">
                            <textarea name="description" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Specializarea: *</label>
                        </div>
                        <div class="col-sm-6">
                            <select name="specialization" class="form-control">
                                <?php foreach($specializations as $category => $values): ?>
                                    <optgroup label="<?=$category?>">
                                        <?php foreach($values as $specialization): ?>
                                            <option value="<?=$specialization?>" <?php if (isset($searchData['specialization']) and $searchData['specialization'] == $specialization) echo "selected"; ?>><?=$specialization?></option>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
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
                        <div class="col-sm-offset-3 col-sm-9">
                            <p class="help-block">Cimpurile marcate cu (*) sunt obligatorii pentru completare</p>
                            <button type="submit" class="btn btn-success">Publica proiectul</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
