<?php

class eventsController extends Controller
{

    private $data_compare = array("title" => "", "description" => "", "start_datetime" => "",  "end_datetime" => "");
    public function index()
    {
        $this->loadView("events");
    }

    public function list()
    {
        // qualquer outro método não será permitido
        if (in_array($_SERVER['REQUEST_METHOD'], array('GET')) === false) :
            echo json_encode(array("success" => false, "message" => "method not allowed", "method" => $_SERVER['REQUEST_METHOD']));
            die();
        endif;
        $eventsModel = new EventsModel();
        echo json_encode($eventsModel->list());
    }

    public function add()
    {
        // qualquer outro método não será permitido
        if (in_array($_SERVER['REQUEST_METHOD'], array('POST')) === false) :
            echo json_encode(array("success" => false, "message" => "method not allowed", "method" => $_SERVER['REQUEST_METHOD']));
            die();
        endif;

        // Recupera as informações enviadas
        $data = json_decode(file_get_contents('php://input'), true);

        // Valida se o array enviado possue as chaves corretas
        $isValid = array_diff_key($data, $this->data_compare);
        if (count($isValid) > 0) :
            echo json_encode(array("success" => false, "message" => "Os dados informados estão incorretos", "data" => json_encode($data)), JSON_UNESCAPED_UNICODE);
            die();
        endif;

        // Prepara o array para inserção no banco de dados
        $eventsModel = new EventsModel();

        $isDuplicated = $eventsModel->isDuplicated(null, $data);
        if ($isDuplicated) :
            echo json_encode(array("success" => false, "message" => "As datas escolhidas já estão ocupadas. Verifique e tente novamente! ", "data" => json_encode($data, JSON_UNESCAPED_UNICODE)));
            die();
        endif;

        $ret = $eventsModel->add($data);
        $data["id"] = $ret;
        echo json_encode(array("success" => true, "message" => "Evento agendado com sucesso! ", "data" => json_encode($data)), JSON_UNESCAPED_UNICODE);
    }

    public function update($id)
    {
        // qualquer outro método não será permitido
        if (in_array($_SERVER['REQUEST_METHOD'], array('PUT')) === false) :
            echo json_encode(array("success" => false, "message" => "method not allowed", "method" => $_SERVER['REQUEST_METHOD']));
            die();
        endif;

        // Recupera as informações enviadas
        $data = json_decode(file_get_contents('php://input'), true);

        // Valida se o array enviado possue as chaves corretas
        $isValid = array_diff_key($data, $this->data_compare);
        if (count($isValid) > 0) :
            echo json_encode(array("success" => false, "message" => "Os dados informados estão incorretos", "data" => json_encode($data)), JSON_UNESCAPED_UNICODE);
            die();
        endif;

        // Prepara o array para inserção no banco de dados
        $eventsModel = new EventsModel();

        // Verifica se há duplicidade no horário informado
        $isDuplicated = $eventsModel->isDuplicated($id, $data);
        if ($isDuplicated) :
            echo json_encode(array("success" => false, "message" => "As datas escolhidas já estão ocupadas. Verifique e tente novamente! ", "data" => json_encode($data, JSON_UNESCAPED_UNICODE)));
            die();
        endif;

        $ret = $eventsModel->upd($id, $data);
        $data["id"] = $id;
        echo json_encode(array("success" => $ret, "message" => $ret == false ? "Ocorreu um erro, tente novamente mais tarde!" : "Evento alterado com sucesso! ", "data" => json_encode($data)), JSON_UNESCAPED_UNICODE);
    }

    public function delete($id)
    {
        // qualquer outro métodonão será permitido
        if (in_array($_SERVER['REQUEST_METHOD'], array('DELETE')) === false) :
            echo json_encode(array("success" => false, "message" => "method not allowed", "method" => $_SERVER['REQUEST_METHOD']));
            die();
        endif;
        $eventsModel = new EventsModel();
        $data = $eventsModel->getById($id);
        $ret = $eventsModel->del($id);
        echo json_encode(array("success" => true, "message" => "Evento excluído com sucesso! ", "data" => json_encode($data)), JSON_UNESCAPED_UNICODE);
    }
}
