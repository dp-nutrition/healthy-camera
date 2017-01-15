<?php
require_once __DIR__.'/DbAbstract.php';
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 2017/01/03
 * Time: 20:53
 */
class ChatLog extends DbAbstract
{

    const EVENT_TYPE_USER_MESSAGE = 'user message';
    const EVENT_TYPE_BOT_MESSAGE = 'bot message';
    const FLOW_NODE_DEFAULT = 0;
    const REPLY_EVENT_ID_NOT_REPLY = 0;


    const EVENT_ID          = "event_id";
    const EVENT_TYPE        = "event_type";
    const MESSAGE           = "message";
    const USER_ID           = "user_id";
    const FLOW_NODE_ID      = "flow_node_id";
    const REPLY_EVENT_ID    = "reply_event_id";
    const CREATED           = "created";

    /**
     * データベースに登録する
     * @param $row
     * @return mixed
     * @throws Exception
     */
    public function insert($row)
    {
        try {
            $this->_db->beginTransaction();
            $stmt = $this->_db->prepare("
                INSERT INTO chat_log
                  (event_type, message, user_id, flow_node_id, reply_event_id, created)
                  VALUES (:event_type, :message, :user_id, :flow_node_id, :reply_event_id, :created);");
            $stmt->execute(array(
                ":event_type"   => $row['event_type'],
                ":message"      => $row['message'],
                ":user_id"      => $row['user_id'],
                ":flow_node_id" => $row['flow_node_id'],
                ":reply_event_id" => $row['reply_event_id'],
                ":created"      => date("Y-m-d H:i:s")
            ));
            $id = $this->_db->lastInsertId('event_id');
            $row = $this->getChatLogByEventId($id);
            // トランザクション完了
            $this->_db->commit();
        } catch (Exception $e) {
            $this->_db->rollBack();
            error($e->getMessage());
            throw $e;
        }
        return $row;
    }

    /**
     * データベースからevent_idのイベントを取得する
     * @param $event_id
     * @return mixed
     */
    private function getChatLogByEventId($event_id)
    {
        try{
            $stmt = $this->_db->prepare("
                SELECT event_id, event_type, message, user_id, flow_node_id, created
                  FROM chat_log
                  WHERE event_id = ?");
            $stmt->execute([$event_id]);
        }catch(PDOException $e){
            error($e->getMessage());
            throw $e;
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}