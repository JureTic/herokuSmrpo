<?php namespace App\Models;

use CodeIgniter\Model;

class NalogeModel extends Model
{
    protected $table = 'naloge';
    protected $allowedFields = ['zgodba_id', 'opis_naloge', 'ocena_casa','clan_ekipe','potrjen'];

    function pridobiNalogeZgodbe($idZgodbe){
        $query = $this->db-> query("SELECT * from naloge WHERE zgodba_id = ".$idZgodbe);
        return $query->getResultArray();
    }

}