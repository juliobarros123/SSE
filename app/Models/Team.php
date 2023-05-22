<?php
/*Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao abrigo do decreto executivo conjunto nº29/85 de 29 de Abril, dos Ministérios da Educação e dos Transportes e Comunicações, publicado no Diário da República, 1ª série nº 35/85, nos termos do artigo 62º da Lei Constitucional.
contactos:
site:www.itel.gov.ao
telefone:[tirar no site]
email: [tirar no site]*/
namespace App\Models;

use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_cabecalho','slug', 
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];
}
