<?php
require_once __DIR__.'/../model/Line.php';
require_once __DIR__.'/../Enum.php';
class IndexController
{
    /**
     * index
     */
    function index()
    {
        $line = new Line(getLineBotAccount());
        $line->receiveMessage();
        $line->sendMessage('ふむふむ。');
        if($line->messageType == 'image'){
            $line->sendMessage('解析中...');
            $img = $line->getImage();
            $foodId = $this->_analyze($img);
            $msg = $foodId;
            $line->sendMessage("food id:".$msg);
            $baseImgUrl = 'https://line.txmy.jp/img/';
            $filename = urlencode($line->userId).'.jpg';
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

    /**
     * 分析プログラムを実行する
     * @param $fileName
     * @return string
     */
    private function _analyze($fileName)
    {
        $exeFile = realpath(__DIR__.'/../../../inference/keras_load_predict_sample.py');
        $fileName = escapeshellarg($fileName);
        $command = 'KERAS_BACKEND=theano /usr/bin/python '.$exeFile.' '.$fileName . ' 2>&1';
        $foodId = exec($command,$out);
        return $foodId;
    }
}

