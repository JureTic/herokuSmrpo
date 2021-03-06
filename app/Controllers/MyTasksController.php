<?php

namespace App\Controllers;

use App\Models\NalogeModel;
use App\Models\UporabniskeZgodbeModel;
use App\Models\UserModel;

class MyTasksController extends BaseController
{
    public function myTasks() {
        $zgodbeModel = new UporabniskeZgodbeModel();
        $nalogeModel = new NalogeModel();
        $userModel = new UserModel();
        $userID = session()->get('id');
        $projectID = session()->get('projectId');

        $mojeZgodbe = $zgodbeModel->getMyStories($userID, $projectID);
        $zgodbeNalog = $zgodbeModel->getMyStoryTasks($userID, $projectID);
        $naloge = $nalogeModel->pridobiMojeNaloge($userID, $projectID);
        $zgodbe = $zgodbeModel->pridobiZgodbe(session()->get("projectId"));

        $stories1 = $this->addResponsibleAdults($zgodbeNalog, $userModel);
        $stories2 = $this->addTasksToStory($stories1, $naloge);
        #print_r($stories);
        #var_dump($stories);



        $zgodberework = $this->pridobizgodbe($zgodbe);
        $data = [
            'zgodbe'=>$stories2,
        ];

        echo view('subpages/projekti/myTasks',$data);
    }

    function addTasksToStory($zgodbeNalog, $naloge) {
        $i = 0;
        foreach ($zgodbeNalog as $zgodba):
            $temp = [];
            $j = 0;
            foreach ($naloge as $naloga):
                if ($zgodba['idZgodbe'] === $naloga['zgodba_id']) $temp += array($j => $naloga);
                $j++;
            endforeach;
            $zgodbeNalog[$i] += array('naloge' => $temp);
            $i++;

        endforeach;
        return $zgodbeNalog;
    }

    function addResponsibleAdults($zgodbe, $usermodel) {
        $i = 0;
        foreach ($zgodbe as $zgodba):
            $user_id = $zgodba['idUporabnika'];
            if ($user_id === null) {
                $zgodbe[$i] += array('odgovorni' => '/');
            } else {
                $username = $usermodel->getUserById($user_id);
                $zgodbe[$i] += array('odgovorni' => $username);
            }
            $i++;
        endforeach;
        return $zgodbe;
    }

    public function changeStatus() {
        $uri = service('uri');

        $status = $uri->getSegment('2');
        $taskId = $uri->getSegment('3');

        $model = new NalogeModel();
        if ($status == 'N') {
            $model->activateWork($taskId);
        } else {
            $model->finishWork($taskId);
        }

        return redirect()->back();
    }
    public function sprejmiNalogo(){
        
    }
    public function zavrniNalogo(){
        
    }
    public function potrdiZgodbo(){
        $zgodbeModel = new UporabniskeZgodbeModel();
        $zgodbaId=0;
        $koncaneVseNaloge=$zgodbeModel->soVseNalogeKoncane($zgodbaId);
        $uporabnik=session()->get('id');
        $jeProduktniVodja=jeProduktniVodja($uporabnik, $idProjekta);
        if($koncaneVseNaloge && $jeProduktniVodja){
            $zgodbeModel->potrdiZgodbo($zgodbaId);
        }
    }
}