<?php
class EventsModel extends Core
{

    public function list()
    {
        // Recupero somente os eventos a partir do dia atual. Os anteriores não são mostrados
        $sql = "SELECT id, title, description, start_datetime, end_datetime, created_at, updated_at, deleted_at
                FROM events WHERE deleted_at IS NULL AND DATE(start_datetime) >= DATE(current_timestamp) ORDER BY start_datetime DESC";
        $data = $this->db->select($sql);
        return (count($data) > 0) ? array("success" => true, "msg" => "success", "data" => $data) : array("success" => false, "msg" => "no data", "data" => []);
    }

    public function add(array $data)
    {
        return $this->db->insert("events", $data);
    }

    // Exclui um evento de forma lógica pelo ID
    public function del($id)
    {
        return $this->db->update("events", array("deleted_at" => date('Y-m-d H:i:s')), "id=$id");
    }

    public function upd($id, $data)
    {
        return $this->db->update("events", $data, "id=$id");
    }

    // Recupera o evento pelo ID
    public function getById($id)
    {
        $sql = "SELECT id, title, description, start_datetime, end_datetime, created_at
                FROM events WHERE id = $id";
        $data = $this->db->select($sql);
        return $data;
    }

    // Verifica se há duplicidade ao informar o intervalo de datas
    public function isDuplicated($id, array $data)
    {
        // Diferença de 1 segundo para permitir a inclusão de um horário após a finalização de outro. 
        // Ex: Evento finaliza as 20h00 e o outro começa as 20h00

        $data = array("start_datetime" => $data["start_datetime"], "end_datetime" => $data["end_datetime"]);
        if ($id === null) :
            $ret = $this->db->select("SELECT id FROM events 
               WHERE :start_datetime BETWEEN DATE_SUB(start_datetime, INTERVAL 1 SECOND) AND DATE_SUB(end_datetime, INTERVAL 1 SECOND)
               OR    :end_datetime BETWEEN DATE_SUB(start_datetime, INTERVAL 1 SECOND) AND DATE_SUB(end_datetime, INTERVAL 1 SECOND)", $data);
            return count($ret) > 0;
        endif;


        $ret = $this->db->select("SELECT id FROM events 
           WHERE start_datetime = :start_datetime
           AND   end_datetime = :end_datetime", $data);

        if ($ret[0]["id"] ==  $id) :
            return false;
        else :
            $ret = $this->db->select("SELECT id FROM events 
               WHERE :start_datetime BETWEEN DATE_SUB(start_datetime, INTERVAL 1 SECOND) AND DATE_SUB(end_datetime, INTERVAL 1 SECOND)
               OR    :end_datetime BETWEEN DATE_SUB(start_datetime, INTERVAL 1 SECOND) AND DATE_SUB(end_datetime, INTERVAL 1 SECOND)", $data);
            return count($ret) > 0;
        endif;
    }
}
