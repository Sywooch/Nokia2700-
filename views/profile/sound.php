<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12.08.2016
 * Time: 14:26
 */
?>
<section class="content">
    <code>
        <?php
        print '<pre>';
        print_r($getUrlSound);
        print '</pre>';
        print '<pre>';
        print_r($sendSound);
        print '</pre>';
        ?>
    </code>
</section>
<?php
$getUrlSound = getUrlSound();
$result = $getUrlSound->result;
$uploadURL = $result->uploadURL;
$sendSound = sendSound($_SERVER['DOCUMENT_ROOT']."/files/robaks.wav", $uploadURL);
print "<code>";
print_r($getUrlSound); //The result is positive
print "</code>";

print "<code>";
print_r($sendSound); //The result is negative
print "</code>";

function getUrlSound()
{
    $customer = '883140779001066';
    $data = array(
        "id" => "1",
        "jsonrpc" => "2.0",
        "method" => "setCallBackPrompt",
        "params" => array(
            "customer_name"=> $customer,
            "file_name" => "robaks.wav"
        )
    );

    if ($mtt_curl = curl_init())
    {
        curl_setopt($mtt_curl, CURLOPT_URL, 'https://webapicommon.mtt.ru/index.php');
        curl_setopt($mtt_curl, CURLOPT_USERPWD, 'ЛОГИН:ПАРОЛЬ');
        curl_setopt($mtt_curl, CURLOPT_POST, 1);
        curl_setopt($mtt_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($mtt_curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($mtt_curl, CURLOPT_POSTFIELDS, json_encode($data));
        $response = json_decode(curl_exec($mtt_curl));
        if ($response === null){
            return false;
        }else{
            return $response;
        }
    } else {
        return false;
    }
}

function sendSound($file, $url)
{
    $file_contents = file_get_contents($file);
    $opts = array(
        "https" =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $file_contents
            )
    );
    $context = stream_context_create($opts);

    return file_get_contents($url, false, $context);
}