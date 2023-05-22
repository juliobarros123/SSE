<?php
// Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao abrigo do decreto executivo conjunto nº29/85 de 29 de Abril, dos Ministérios da Educação e dos Transportes e Comunicações, publicado no Diário da República, 1ª série nº 35/85, nos termos do artigo 62º da Lei Constitucional.
//contactos:
//site:www.itel.gov.ao
//telefone:[tirar no site]
//email: [tirar no site]
namespace App\Models;

use Laravel\Jetstream\Membership as JetstreamMembership;

class Membership extends JetstreamMembership
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
