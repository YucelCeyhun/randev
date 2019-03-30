<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Companies
{
    private  function UserResult($userResult){
        $allUsers = "";
        foreach ($userResult as $user){
            $allUsers .='<option value="'.$user->id.'">'.$user->username.'</option>';
        }
        return $allUsers;
    }

    public function CreateCompanyFrom($userResult){

        $result = $this->UserResult($userResult);

        return '<form>
        <div class="form-group">
            <label for="name">Adı:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Firma Adı">
        </div>
        <div class="form-group">
            <label for="address">Adresi:</label>
            <input type="text" class="form-control" id="address" placeholder="Firma Adresi" name="address">
        </div>
        <div class="form-group">
            <label for="tel">Telefon No:</label>
            <input type="text" class="form-control" id="tel" placeholder="Firma Telefon No" name="tel" maxlength="10">
        </div>
        <div class="form-group">
            <label for="email">E-mail Adresi(eğer varsa):</label>
            <input type="email" class="form-control" id="email" placeholder="örnek@domain.com" name="email">
        </div>
        <div class="form-group">
        <label for="users">Firma Randevucusu(eğer varsa):</label>
            <select class="form-control" id="users" name="users"><option value="0"></option>'.$result.'</select>
        </div>
        <button type="button" class="btn btn-primary btn-lg mt-5 float-right" id="createBtn">Oluştur</button>
    </form><script type="text/javascript" src="' . base_url('assets/js/createcompany.js') . '"></script>';

    }
}