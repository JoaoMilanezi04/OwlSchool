<?php



date_default_timezone_set('America/Sao_Paulo');




function proximoDiaDeAula() {
  $mapKey = [
    1 => 'segunda',
    2 => 'terca',
    3 => 'quarta',
    4 => 'quinta',
    5 => 'sexta'
  ];

  $mapLabel = [
    'segunda' => 'Segunda-feira',
    'terca'   => 'Terça-feira',
    'quarta'  => 'Quarta-feira',
    'quinta'  => 'Quinta-feira',
    'sexta'   => 'Sexta-feira'
  ];






  $agora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
  $diaSemana = (int)$agora->format('N');




  if ($diaSemana >= 5) {
    $proximo = (clone $agora)->modify('next monday');
  } else {
    $proximo = (clone $agora)->modify('+1 day');
    if ((int)$proximo->format('N') >= 6) {
      $proximo->modify('next monday');
    }
  }




  $key = $mapKey[(int)$proximo->format('N')];

  return [
    'key'     => $key,
    'label'   => $mapLabel[$key],
    'date'    => $proximo->format('Y-m-d'),
    'date_br' => $proximo->format('d/m/Y')
  ];
}
