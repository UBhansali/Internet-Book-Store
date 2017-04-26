<?php
function encode($key, $payload)
{
    $b64_enc_h = json_encode(array('jwt' => 'jwt', 'type' => 'HS256'));
    $b64_enc_h = str_replace("+/", "-_", base64_encode($b64_enc_h)); // Round 1
    $b64_enc_h = str_replace("=", "", $b64_enc_h);

    $b64_enc_p = json_encode($payload);
    $b64_enc_p = str_replace("+/", "-_", base64_encode($b64_enc_p)); // Round 2
    $b64_enc_p = str_replace("=", "", $b64_enc_p);

    $vals[0] = $b64_enc_h;
    $vals[1] = $b64_enc_p;
    
    $sign = sign(implode(".", $vals), $key);
    $b64_enc_s = json_encode($sign);
    $b64_enc_s = str_replace("+/", "-_", base64_encode($b64_enc_s)); // Round 3
    $b64_enc_s = str_replace("=", "", $b64_enc_s);

    $vals[2] = $b64_enc_s;

    return implode(".", $vals);
}

function sign($item, $secret)
{
    return hash_hmac("sha256", $item, $secret, true);
}

function decode($jwt, $key)
{
    $val = explode(".", $jwt);
    $headb64 = $val[0];
    $payloadb64 = $val[1];
    $cryptob64 = $val[2];

    $hd64_v = strlen($headb64) % 4;
    if ($hd64_v)
    {
        $padlen = 4 - $hd64_v;
        $hd64_v .= str_repeat("=", $padlen);
    }

    $pl64_v = strlen($payloadb64) % 4;
    if ($pl64_v)
    {
        $padlen = 4 - $pl64_v;
        $payloadb64 .= str_repeat("=", $padlen);
    }
    $pl64_v = json_decode(base64_decode(strtr($payloadb64, '-_', '+/')));

    if ($hd64_v == null | $pl64_v == null)
    {
        return null;
    }
    else
    {
        $cr64_v = strlen($cryptob64) % 4;
        if ($cr64_v)
        {
            $padlen = 4 - $cr64_v;
            $cryptob64 .= str_repeat("=", $padlen);
        }
        $sig = $cryptob64;
    }
    return $pl64_v;
}
?>