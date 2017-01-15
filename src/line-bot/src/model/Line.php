<?php

/**
 * LINE APIを扱うためのクラス
 * Created by PhpStorm.
 * User: Tom
 * Date: 2016/12/30
 * Time: 21:11
 */
class Line
{
    public $accessToken = '';
    public $httpClient;
    public $replyToken = '';
    public $messageType = '';
    public $type = '';
    public $message = '';
    public $userId = '';

    /**
     * Line constructor.
     * @param $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($accessToken);
    }

    /**
     * メッセージを送信する
     * @param $sendText String 送信メッセージ
     * @param $userId String 宛先のユーザーID
     * @return mixed
     */
    public function sendMessage($sendText, $userId = '')
    {
        if (empty($userId) && empty($this->userId)){
            error('Line::sendMessage($sendText)でエラーが発生しました。userIdがセットされていません。');
        }else if (empty($userId)){
            $userId = $this->userId;
        }
        $responseFormatText = [
            "type"=>"text",
            "text"=>$sendText
        ];
        $postData = [
            "to"        => $userId,
            "messages"  => [$responseFormatText]
        ];
        $ch = curl_init("https://api.line.me/v2/bot/message/push");
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($postData));
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            'Content-Type: application/json; charset=UTF-8',
            'Authorization: Bearer '.$this->accessToken
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function sendImage($imageUrl, $userId = '')
    {
        if (empty($userId) && empty($this->userId)){
            error('Line::sendImage()でエラーが発生しました。userIdがセットされていません。');
        }else if (empty($userId)){
            $userId = $this->userId;
        }
        $responseFormatText = [
            "type"                  => "image",
            "originalContentUrl"    => $imageUrl,
            "previewImageUrl"       => $imageUrl
        ];
        $postData = [
            "to"        => $userId,
            "messages"  => [$responseFormatText]
        ];
        $ch = curl_init("https://api.line.me/v2/bot/message/push");
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($postData));
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            'Content-Type: application/json; charset=UTF-8',
            'Authorization: Bearer '.$this->accessToken
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * メッセージを受け取る
     */
    public function receiveMessage()
    {
        $body               = file_get_contents('php://input');
        $jsonObj            = json_decode($body);
        $this->type  = $jsonObj->{"events"}[0]->{"type"};
        if ($this->type == 'message'){
            $this->messageType  = $jsonObj->{"events"}[0]->{"message"}->{"type"};
            $this->message      = $jsonObj->{"events"}[0]->{"message"}->{"text"};
        }
        $this->replyToken   = $jsonObj->{"events"}[0]->{"replyToken"};
        $this->userId       = $jsonObj->{"events"}[0]->{"source"}->{"userId"};
        return $this->message;
    }

    /**
     * メッセージを返す
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function sendSticker($sticker, $userId = '')
    {
        if (empty($userId) && empty($this->userId)){
            error('Line::sendImage()でエラーが発生しました。userIdがセットされていません。');
        }else if (empty($userId)){
            $userId = $this->userId;
        }
        $responseFormatText = [
            "type"         => "sticker",
            "packageId"    => 1,
            "stickerId"    => $sticker
        ];
        $postData = [
            "to"        => $userId,
            "messages"  => [$responseFormatText]
        ];
        $ch = curl_init("https://api.line.me/v2/bot/message/push");
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($postData));
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            'Content-Type: application/json; charset=UTF-8',
            'Authorization: Bearer '.$this->accessToken
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}