<?php
require_once __DIR__.'/../model/Line.php';
require_once __DIR__.'/../Enum.php';
class IndexController
{
    function index()
    {
        $line = new Line(getLineBotAccount());
        $line->receiveMessage();
        $line->sendMessage('ふむふむ。');
        if($line->messageType == 'image'){
            $img = $line->getImage();
            $line->sendMessage('解析完了！');
            $baseImgUrl = 'https://line.txmy.jp/img/';
            $filename = 'test.jpg';
            $line->sendImage($baseImgUrl . $filename);
        }else if($line->messageType == 'text'){
            $message = $line->getMessage();
            $line->sendMessage($message.'なんだね。');
        }else if($line->messageType == 'sticker'){
            $id = rand(1,50);
            $line->sendSticker($id);
        }else if($line->messageType == 'location'){
            $line->sendMessage('僕の住所はこちら：〒113-8654 東京都文京区本郷７丁目３−１');
        }else if($line->messageType == 'audio'){
            $line->sendMessage('音声認識はまだ勉強中なんです．．．．．．');
        }else if($line->messageType == 'video'){
            $line->sendMessage('楽しそうだね！');
        }
    }
}

