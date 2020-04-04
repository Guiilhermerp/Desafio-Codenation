<?php
$url = "https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token=3c326734d699d6a1fe5fac1066802a0749692673";

$conteudoAPI = json_decode(file_get_contents($url));

// Tranforma o array $conteudoAPI em JSON
$dados_json = json_encode($conteudoAPI);
 
// Cria o arquivo cadastro.json
// O parâmetro "a" indica que o arquivo será aberto para escrita
$fp = fopen("answer.json", "a+");
 
// Escreve o conteúdo JSON no arquivo
$escreve = fwrite($fp, $dados_json);
 
// Fecha o arquivo
fclose($fp);



// ------------ LOGICA PARA DECIFRAR ------------

// Atribuindo os valor do array para variaveis
$cifrado = $conteudoAPI->cifrado;
$numeroCasas = $conteudoAPI->numero_casas;

    // Usando a função range para percorrer o alfabeto
    $char = range('a', 'z');
    // Usando a função arra_flip para mudar a posição de cada letra
    $flip = array_flip($char);

    // For para percorrer a frase cifrada
    for ($i = 0; $i < strlen($cifrado); $i++) {
        // condição parar trocar as letras 
        if (in_array(strtolower($cifrado{$i}), $char)) {
            $ord = $flip[strtolower($cifrado{$i})];

            $ord = ($ord - $numeroCasas) % 26;

            if ($ord < 0) $ord += 26;

            $cifrado{$i} = ($cifrado{$i} == strtolower($cifrado{$i})) ? $char[$ord] : strtoupper($char[$ord]);
        }
    }

    // atribuido a frase decifrada a sua varivel
    $decifrado = $cifrado;

    // Atualizando o decifrado com o novo conteudo
    $conteudoAPI->decifrado = $decifrado;
    $json_dados = json_encode($conteudoAPI);
    file_put_contents('answer.json', $json_dados);

    //Criptografando a frase decifrado com SHA1 e atualizando o json
    $criptografado = sha1($decifrado);
    $conteudoAPI->resumo_criptografico = $criptografado;
    $json_dados = json_encode($conteudoAPI);
    file_put_contents('answer.json', $json_dados);
    

    // --------------------------------------------------
    
    // ----- CONDIGO PARA POST DO JSON

    // $urlSolucao = "https://api.codenation.dev/v1/challenge/dev-ps/submit-solution?token=3c326734d699d6a1fe5fac1066802a0749692673";

    // $content = json_encode($conteudoAPI);

    // $curl = curl_init($urlSolucao);
    // curl_setopt($curl, CURLOPT_HEADER, false);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_HTTPHEADER,
    //         array("Content-type: multipart/form-data"));
    // curl_setopt($curl, CURLOPT_POST, true);
    // curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    // $json_response = curl_exec($curl);

    // $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    // if ( $status != 201 ) {
    //     die("Error: call to URL $urlSolucao failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    // }


    // curl_close($curl);

    // $response = json_decode($json_response, true);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<div class="container">
    <class="row">
        <form enctype="multipart/form-data" method="post" action='https://api.codenation.dev/v1/challenge/dev-ps/submit-solution?token=3c326734d699d6a1fe5fac1066802a0749692673'>
            Selecione o JSON: <br><br>
            <input type="file" name="answer"> <br><br>			
            <button onClick="return confirm('Deseja enviar o arquivo?');" class="btn btn-primary" type="submit" name="Submit" value="Enviar" >
                enviar
            </button>
        </form>
    </row>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

