<?php
define('URL', 'https://www.reclameaqui.com.br/empresa/loja-targa/');

//Remover erros de tags HTML5
libxml_use_internal_errors(true);

//Adicione tipos de USERAGENT para burlar o reclame aqui
$headers = array(
  'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36',
  'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
);

//Lista com imagens de cada ranking
$imagens = array(
  'SEM ÍNDICE' => 1,
  'EM ANÁLISE' => 2,
  'NÃO RECOMENDADA' => 3,
  'RUIM' => 4,
  'REGULAR' => 5,
  'BOM' => 6,
  'ÓTIMO' => 7,
  'RA1000' => 8,
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_USERAGENT,$headers[rand(0,count($headers) -1)]);

$output = curl_exec($ch);
$erro = curl_error($ch);
curl_close($ch);

if ($erro) {
  echo json_encode(array('status' => 'erro'));
}

$documento = new DOMDocument();
$documento->loadHTML($output);

$xPath = new DOMXPath($documento);

//Score
$score = $xPath->query('.//span[@class="score"]');
foreach ($score as $elemento) {
  echo $elemento->textContent.PHP_EOL;
}

//Titutlo
$titulo = $xPath->query('.//span[@class="description"]');
foreach ($titulo as $elemento) {
  echo $imagens[$elemento->textContent];
}
