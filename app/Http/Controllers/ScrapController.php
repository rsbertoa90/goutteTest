<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use Goutte\Client;
 use Symfony\Component\DomCrawler\Crawler;
 use App\Http\Requests;


class ScrapController extends Controller
{

  function scrap()
  {
    //nueo cliente
      $client = new Client();

// defino usuario y clave para ingresar
      $user = '2034600999';   // USUARIO AFIP - CUIL/CUIT
      $pass = 'XXXXXX';   // CLAVE FISCAL

// voy a la url de ingreso
      $crawler = $client->request('GET', 'https://auth.afip.gob.ar/contribuyente_/login.xhtml');
// asigno el formulario que tiene el boton "siguiente" en la variable $form
      $form = $crawler->selectButton('F1:btnSiguiente')->form();
// hago submit de ese formulario con el dato user en el field F1:username
      $crawler = $client->submit($form, array('F1:username' => $user));
      sleep(2);
// esto me lleva a la segunda pantalla. donde pide la clave
// de nuevo, cargo el formulario del boton que ahora es "F1:ingresar", a la variable form.
      $form = $crawler->selectButton('F1:btnIngresar')->form();
// hago submit de este form con los 2 datos. user y password
      $crawler = $client->submit($form, array('F1:password'=>$pass , 'F1:username'=>$user));
      sleep(2);

// busco el contenido del div con id=nombre, que tiene el nombre del usuario actualmente logueado
       $crawler->filter('div[id="nombre"]')->each(function ($node) {
         print $node->text() . "<br><br><br><br>";
       });

  }

}
