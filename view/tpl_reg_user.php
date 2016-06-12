<section class="registration-section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <h2>Inregistreaza-te <small>Este gratis si asa va fi mereu</small></h2>
                <form method="post" enctype="multipart/form-data" accept-charset="UTF-8">
                    <div id="user-role" class="form-group btn-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-default">
                            <input type="radio" name="role" value="freelancer"> SUNT FREELANCER
                        </label>
                        <label class="btn btn-default active">
                            <input type="radio" name="role" value="employer" checked>  SUNT ANGAJATOR
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Adresa de email *</label>
                        <input type="email" name="email" placeholder="Introduceti adresa de email aici..." class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Parola *</label>
                        <input type="password" name="password" placeholder="Introduceti parola aici..." class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Nume *</label>
                            <input type="text" name="lastName" placeholder="Introduceti numele aici..." class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Prenume *</label>
                            <input type="text" name="firstName" placeholder="Introduceti prenumele aici..." class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label>Data nasterii (an-luna-zi) *</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select name="year" class="form-control">
                                <script type="text/javascript">
                                    for (i = 1999; i > 1939; i--) {
                                        document.write("<option value='"+i+"'>"+i+"</option>");
                                    }
                                </script>
                            </select>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select name="month" class="form-control">
                                <option value="1">Ianuarie</option>
                                <option value="2">Februarie</option>
                                <option value="3">Martie</option>
                                <option value="4">Aprilie</option>
                                <option value="5">Mai</option>
                                <option value="6">Iunie</option>
                                <option value="7">Iulie</option>
                                <option value="8">August</option>
                                <option value="9">Septembrie</option>
                                <option value="10">Octombrie</option>
                                <option value="11">Noiembrie</option>
                                <option value="12">Decembrie</option>
                            </select>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select name="day" class="form-control">
                                <script type="text/javascript">
                                    for (i = 01; i <= 31; i++) {
                                        document.write("<option value='"+i+"'>"+i+"</option>");
                                    }
                                </script>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Sex *</label>
                        <div style="clear:both;"></div>
                        <label class="radio-inline">
                            <input type="radio" name="sex" value="M"> M
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sex"  value="F"> F
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Imagine de profil</label>
                        <input type="file" accept="image/*" name="profileImage">
                        <p class="help-block">Se accepta doar imagini in format JPG, PNG sau GIF</p>
                    </div>
                    <div class="form-group">
                        <label>Numar de telefon</label>
                        <input type="tel" name="phoneNumber" placeholder="Introduceti numarul de telefon aici.." class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Cont de skype</label>
                        <input type="tel" name="skypeAccount" placeholder="Introduceti contul de skype aici.." class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Adresa de domiciliu</label>
                        <input type="text" name="address" placeholder="Introduceti adresa aici.." class="form-control">
                    </div>
                    <p class="help-block">Cimpurile marcate cu (*) sunt obligatorii pentru completare</p>
                    <button type="submit" name="regBtn" class="btn btn-success">Creare cont</button>
                </form>
            </div>
        </div>
    </div>
</section>