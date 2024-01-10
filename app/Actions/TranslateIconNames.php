<?php

namespace App\Actions;

class TranslateIconNames {
  function index($language) {
    switch ($language) {
      case 'DK':
        return [
          'name' => 'Juridisk navn',
          'cvr' => 'CVR-nr',
          'cvr_short' => 'CVR-nr',
          'employees' => 'Antal ansatte',
          'employees_short' => 'Antal ansatte',
          'address' => 'Adresse',
          'founded_at' => 'Startdato',
          'phone' => 'Telefon',
          'company_type' => 'Selskabsform',

          //For scraping employees
          'company_url' => 'https://www.proff.dk/firma/r/r/r'
        ];
  
      case 'FI':
        return [
          'name' => 'Virallinen nimi',
          'cvr' => 'Y-tunnus',
          'cvr_short' => 'Y-tunnus',
          'employees' => 'Työntekijät',
          'employees_short' => 'Työntekijät',
          'address' => 'Osoite',
          'founded_at' => 'Rekisteröintipäivä',
          'phone' => 'Puhelin',
          'company_type' => 'Yhtiömuoto',

          //For scraping employees
          'company_url' => 'https://www.proff.fi/yrityksen/r/r/r'
        ];
      
      case 'NO':
        return [
          'name' => 'Juridisk navn',
          'cvr' => 'Org nr',
          'cvr_short' => 'Org nr',
          'employees' => 'Antall ansatte',
          'employees_short' => 'Ansatte',
          'address' => 'Adresse',
          'founded_at' => 'Stiftelsesdato',
          'phone' => 'Telefon',
          'company_type' => 'Selskapsform',

          //For scraping employees
          'company_url' => 'https://www.proff.no/selskap/r/r/r'
        ];
    
      case 'SV':
        return [
          'name' => 'Juridiskt namn',
          'cvr' => 'Organisationsnummer',
          'cvr_short' => 'Org.nr',
          'employees' => 'Antal anställda',
          'employees_short' => 'Anställda',
          'address' => 'Adress',
          'founded_at' => 'Registreringsdatum',
          'phone' => 'Telefon',
          'company_type' => 'Bolagsform',

          //For scraping employees
          'company_url' => 'https://www.proff.se/foretag/r/r/r'
        ];
    }
  }
}