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
            $foodId = (int) $this->_analyze($img);
            $foodName = $this->_getFoodNameByFoodId($foodId);
//            $msg = $this->_getRandomFoodNameMessage($foodName);
//            $line->sendMessage($msg);
            $line->sendMessage($this->_advice($foodId));
            $line->sendSticker($this->_getRandomStamp());
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
     * foodIdからアドバイスを返す
     * @param $foodId
     * @return string
     */
    private function _advice($foodId)
    {
        $exeFile = realpath(__DIR__.'/../../../give_advice/give_advice.py');
        $command = 'LANG=ja_JP.UTF-8 /usr/bin/python '.$exeFile.' '.$foodId . ' 2>&1';
        exec($command,$out);
        $msg = "";
        foreach($out as $row){
            $msg .= $row."\n";
        }
        return $msg;
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


    /**
     * ランダムなスタンプのIDを返す
     * @return mixed
     */
    private function _getRandomStamp()
    {
        $stamp = array(
            2,13,14,106,112,124,125,401
        );
        return $stamp[rand(0,count($stamp) - 1)];
    }

    /**
     * Food IDから食べ物の名前を返す
     * @param $foodId
     * @return mixed
     */
    private function _getFoodNameByFoodId($foodId)
    {
        $foods = array(
            "サンドイッチ",
            "チーズケーキ",
            "カルボナーラ",
            "ボロネーゼ",
            "チャーハン",
            "リゾット",
            "寿司",
            "味噌汁"
        );
        return $foods[$foodId];
    }

    /**
     * 食事名をあてた後に送るメッセージ
     * ランダムなメッセージを返す
     * @param $foodName
     * @return mixed|string
     */
    private function _getRandomFoodNameMessage($foodName)
    {

        $messages = array(
            "今日は{$foodName}を食べたんですね！",
            "{$foodName}！おいしそうですね！",
            "{$foodName}は僕も大好きです。",
            "{$foodName}うまそー！"
        );
        if ($foodName == "サンドイッチ" && rand(0,1) > 0){
            return "サンドイッチ伯爵がゲームするときに片手で食べれるものを考えたのがサンドイッチなんだってよ！";
        }
        if ($foodName == "寿司" && rand(0,1) > 0){
            return "「ガリ」の語源はガリッって音するからなんだって！安易(笑)";
        }
        return $messages[rand(0,count($messages))];
    }
}

