<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\UserModel;

class CardTableController extends BaseController
{

    public function cardTable(){

        $uri = service('uri');
        $id = $uri->getSegment('2');
        $model = new ProjectModel();
        $project = $model->find($id);
        $data = [
            'projectId'=>$id,
            'projectName'=>$project['ime']
        ];
        session()->set($data);

        $feedbackAlert = session()->get('feedback');

        if ($feedbackAlert == 'zgodba') {
            $popupdata = ['popup' => 'Zgodba je bila dodana'];
            session()->setFlashdata($popupdata);
        } else if ($feedbackAlert == 'sprint') {
            $popupdata = ['popup' => 'Sprint je bil dodan.'];
            session()->setFlashdata($popupdata);
        }

        return redirect()->to('/Pbacklog');
    }
}