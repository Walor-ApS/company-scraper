<?php

namespace App\Actions;

class TranslateIconNames {
  function index($language) {
    switch ($language) {
      case 'DK':
        return [
          'name' => 'Juridisk navn',
          'cvr' => 'CVR-nr',
          'employees' => 'Antal ansatte',
          'address' => 'Adresse',
          'founded_at' => 'Startdato',
          'phone' => 'Telefon',
          'company_type' => 'Selskabsform',
        ];
  
      case 'FI':
        return [
          'name' => 'Virallinen nimi',
          'cvr' => 'Y-tunnus',
          'employees' => 'Työntekijät',
          'address' => 'Osoite',
          'founded_at' => 'Rekisteröintipäivä',
          'phone' => 'Puhelin',
          'company_type' => 'Yhtiömuoto',
        ];
      
      case 'NO':
        return [
          'name' => 'Juridisk navn',
          'cvr' => 'Org nr',
          'employees' => 'Antall ansatte',
          'address' => 'Adresse',
          'founded_at' => 'Stiftelsesdato',
          'phone' => 'Telefon',
          'company_type' => 'Selskapsform',
        ];
    
      case 'SV':
        return [
          'name' => 'Juridiskt namn',
          'cvr' => 'Organisationsnummer',
          'employees' => 'Antal anställda',
          'address' => 'Adress',
          'founded_at' => 'Registreringsdatum',
          'phone' => 'Telefon',
          'company_type' => 'Bolagsform',
        ];
    }
  }
}