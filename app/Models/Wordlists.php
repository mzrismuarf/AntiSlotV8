<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wordlists extends Model
{
    use HasFactory;

    protected $table = 'wordlists';
    protected $fillable = [
        'slot',
        'backdoor',
        'disable_file_modif',
        'disable_xmlrpc',
        'patch_cve',
        'validation_upload',
        'best_wordlist_slot'
    ];
}
