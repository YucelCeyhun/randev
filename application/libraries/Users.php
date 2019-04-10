<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users
{
    public function CreateUserFrom(){
            return '<form>
            <div class="form-group">
                <label for="name">Randevucunun Adı:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ad ve Soyad">
            </div>
            <div class="form-group">
                <label for="password">Şifre:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Şifre">
            </div>
            <div class="form-group">
                <label for="password-repeat">Şifre Tekrar:</label>
                <input type="password" class="form-control" id="password-repeat" name="password-repeat" placeholder="Şifre Tekrar">
            </div>
            <div class="form-group">
                <label for="tel">Cep No:</label>
                <input type="text" class="form-control" id="tel" placeholder="Cep Telefonu Numarası" name="tel" maxlength="10">
            </div>
            <div class="form-group">
                <label for="email">E-Mail Adresi:</label>
                <input type="email" class="form-control" id="useremail" placeholder="örnek@domain.com" name="useremail">
            </div>
            <div class="form-group">
            <label for="companies">Randevucunun Firmaları(eğer varsa)(birden fazla seçim için control tuşunu kullanın):</label>
                <select multiple class="form-control" id="companies" name="companies">
                  <option>Otis</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
            </div>
            <div class="form-group">
            <label for="engineers">Randevucunun Mühendisleri(eğer varsa)(birden fazla seçim için control tuşunu kullanın):</label>
                <select multiple class="form-control" id="engineers" name="engineers">
                  <option>Ceyhun Yücel</option>
                  <option>Hozan Çetinkaya</option>
                  <option>Volkan İnan</option>
                  <option>Caner Soykök</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary btn-lg mt-5 float-right" id="createBtn">Oluştur</button>
        </form><script type="text/javascript" src="' . base_url('assets/js/createuser.js') . '"></script>';

    }

}
?>
