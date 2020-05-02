<?php
namespace App\Controller;


use App\Controller\AppController;
use App\Controller\Services\EmailService;
use App\Model\Table\AppritiatespostsTables;
use App\Model\Table\CategorysTables;
use App\Model\Table\NotificationsTables;
use App\Model\Table\PostsTables;
use App\Model\Table\ProfilesTables;
use App\Model\Table\TrafficsTables;
use App\Model\Table\TransactionsTables;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
use Cake\Mailer;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\EntityInterface;



class ApiController extends AppController{


    public $base_url;

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->base_url=Router::url("/",true);
        $connection = ConnectionManager::get('default');
        // $this->table=TableRegistry::get("user");
        $this->loadModel('Files');
        $this->Setting=$this->loadModel("setting");
        $this->Wallet=$this->loadModel("Wallet");
        $this->Posts=$this->loadModel(PostsTables::class);
        $this->Categories=$this->loadModel(CategorysTables::class);
        $this->Appritiate=$this->loadModel(AppritiatespostsTables::class);
        $this->Traffic=$this->loadModel(TrafficsTables::class);

        $this->Profile=$this->loadModel(ProfilesTables::class);
        $this->Notification=$this->loadModel(NotificationsTables::class);
        $this->Transaction=$this->loadModel(TransactionsTables::class);
        $session = $this->getRequest()->getSession();
        $this->authorize();
        $email=$session->read('user');
        if($email== null ){


        }
        $this->Users=$this->loadModel("User");
        $dataobj=$this->Users->find("all")->where(["email"=>$email])->toList();
        $userid=$dataobj[0]['id'];

        $this->set("adminame",$dataobj[0]['f_name']);

        $totaltraf=0;
        $totalappri=0;
        $post=$this->Posts->findAllByUserId($userid)->toArray();
        foreach ($post as $p){
            $total = $this->Appritiate->find()->where(['post_id'=>$p['id'] ])->count();
            $traffic = $this->Traffic->find()->where(['post_id'=>$p['id'] ])->toArray();
            foreach ($traffic as $t){
                $totaltraf=$totaltraf+$t['count'];

            }
            $totalappri=$totalappri+$total;



        }
        $settingtrafficcost=$this->Setting->findByName('per_traffic_cost')->toArray();
        $appritiatecost=$this->Setting->findByName('per_appritiate_cost')->toArray();
        $trcost=$settingtrafficcost[0]['value'];
        $apcost=$appritiatecost[0]['value'];


        $notifications=$this->Notification->findAllByUserId($userid)->toArray();

        $notificationsall=$this->Notification->findAllByUserId(0)->toArray();
        //array_push($notifications,$notificationsall);
        //var_dump($notifications);exit;
        $this->set("earning",$this->getcost()['totalearn']);
        $this->set("traffic",$totaltraf);
        $this->set("appritiate",$totalappri);
        $this->set("notification",$notifications);

        $this->set("title","Dashboard");
    }


public function index(){


    var_dump("ASfasfasf");exit;

}



}

?>